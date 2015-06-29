<?php
/*
 * Parse the phone from 4xxx-xxx or 15-xxxx-xxxx
 * to +54 9 11 xxxx xxxx (for celphones)
 * or +54 11 xxxx xxxx
 */
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Person;
use Conner\Tagging\Tag;
use App\Role;
use App\Permission;

function parse_phone($phone)
{
    if(is_array($phone) && count($phone) == 1)
        $phone = array_values($phone)[0];
    if($phone == null)
        return ;
    $clean = preg_replace("/[^0-9]/","",$phone);
    if(strlen($clean) == 8 && substr($clean,0,1) == "4") // linea fija 4xxx-xxxx
    {
        return phone_format("11".$clean,'AR');
    }
    if(strlen($clean) == 10) //celular
    {
        if(substr($clean,0,2) == "15") //15-xxxx-xxxx
            return phone_format("911".substr($clean,2),'AR');
        if(substr($clean,0,2) == "11") //11-xxxx-xxxx
            return phone_format("9".$clean,'AR');
    }
    if(strlen($clean) == 12 && substr($clean,0,4) == "5411" )
    {
        return phone_format($clean,'AR'); //54 11 xxxx xxxx
    }
    if(strlen($clean) == 13 && substr($clean,0,5) == "54911")
    {
        return phone_format($clean,'AR');
    }
    return $clean;
}

// Returns an array with all the tag names
function all_tags() // e.g. [ "tag1" => "tag1", "tag2" => "tag2" ]
{
    return Tag::orderBy('name')->lists('name', 'name');
}

// Returns true if an array has tags that doesn't exist.
function any_new_tag($tags)
{
    foreach($tags as $tag)
    {
        if(Tag::where("name",$tag)->count() == 0)
            return true;
    }
    return false;
}

function allowed_to_tag($user,$tags)
{
    return (any_new_tag($tags) && $user->can('add-tag') || !any_new_tag($tags));
}

function sendMailToUsers($users,$person)
{
    if ($users != null && count($users) > 0 && $person != null)
    {
        $data = array('person' => $person->name());
        Mail::raw(trans('messages.derivationMailContent').$data['person'].'.', function($message) use ($users,$data)
    {
        foreach ($users as $user)
        {
            $message->to($user->email)->subject(trans('messages.newDerivation'));
        }
    });
    }
}

function sendMail($destinationMail,$person){
    if ($destinationMail != null && $person != null)
    {
        $data = array('destination' => $destinationMail, 'person' => $person->name());
        Mail::raw(trans('messages.derivationMailContent').$data['person'].'.', function($message) use ($data)
    {
        $message->to($data['destination'])->subject(trans('messages.newDerivation'));
    });
    }
}

// Returns an array with all the user names
function all_users() // e.g. [ "user1" => "idUser1", "user2" => "idUser2" ]
{
    return $users = User::orderBy('name')->lists('name','id'); // all users
}

// Returns an array with all the people names
function all_people() // e.g. [ "person1" => "idUser1", "person2" => "idUser2" ]
{
    return $people = Person::select('id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'))
        ->orderBy('first_name')
        ->lists('full_name', 'id');
}

function getUserName($id)
{
    $user = User::find($id);
    if ($user != null)
    {
        return $user->name;
    }
    return "";
}

function getPersonName($id)
{
    $person = Person::find($id);
    if ($person != null)
    {
        return $person->name();
    }
    return "";
}

function removeSpecialCharactersCSV($text)
{
    return strtr($text, array(',' => '', '"' => '', '\\' => '', '/' => ''));
}

function removeAccents($text)
{
    $notAllowed = array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $allowed = array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    return str_replace($notAllowed,$allowed,$text);
}

function humanReadableFileSize($bytes, $decimals = 2)
{
    $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)).' '.@$size[$factor];
}

function schema_already_setup()
{
    return Schema::hasTable('users') &&
        Schema::hasTable('roles') &&
        Schema::hasTable('role_user') &&
        Schema::hasTable('permissions') &&
        Schema::hasTable('permission_role');
}
function create_roles_and_permissions()
{
    // Roles
    $admin = new Role();
    $admin->name         = 'admin';
    $admin->display_name = 'Administrador'; // optional
    $admin->description  = 'Usuario administrador con acceso completo e irrestricto.'; // optional
    $admin->save();

    $posadero = new Role();
    $posadero->name         = 'posadero';
    $posadero->display_name = 'Posadero'; // optional
    $posadero->description  = 'Usuario avanzado con acceso a las páginas de asistidos, interacciones y usuarios.'; // optional
    $posadero->save();

    $explorer = new Role();
    $explorer->name         = 'explorer';
    $explorer->display_name = 'Samaritano'; // optional
    $explorer->description  = 'Usuario explorador con acceso a las páginas de asistidos e interacciones.'; // optional
    $explorer->save();

    $newUser = new Role();
    $newUser->name         = 'new-user';
    $newUser->display_name = 'Nuevo usuario'; // optional
    $newUser->description  = 'Nuevo usuario sólo con derechos para dar de alta asistidos e interacciones.'; // optional
    $newUser->save();

    // Permissions
    $seePeopleSearchView = new Permission();
    $seePeopleSearchView->name         = 'see-people-search-view';
    $seePeopleSearchView->display_name = 'Ver página de búsqueda de asistidos'; // optional
    $seePeopleSearchView->description  = 'Ver la página de búsqueda avanzada de asistidos.'; // optional
    $seePeopleSearchView->save();

    $seeInteractionsSearchView = new Permission();
    $seeInteractionsSearchView->name         = 'see-interactions-search-view';
    $seeInteractionsSearchView->display_name = 'Ver página de búsqueda de interacciones'; // optional
    $seeInteractionsSearchView->description  = 'Ver la página de búsqueda avanzada de interacciones.'; // optional
    $seeInteractionsSearchView->save();

    $seeUsersSearchView = new Permission();
    $seeUsersSearchView->name         = 'see-users-search-view';
    $seeUsersSearchView->display_name = 'Ver página de búsqueda de usuarios'; // optional
    $seeUsersSearchView->description  = 'Ver la página de búsqueda avanzada de usuarios.'; // optional
    $seeUsersSearchView->save();

    $seeTags = new Permission();
    $seeTags->name         = 'see-tags';
    $seeTags->display_name = 'Ver etiquetas'; // optional
    $seeTags->description  = 'Ver las etiquetas existentes.'; // optional
    $seeTags->save();

    $editTags = new Permission();
    $editTags->name         = 'edit-tags';
    $editTags->display_name = 'Editar etiquetas'; // optional
    $editTags->description  = 'Editar las etiquetas del sistema.'; // optional
    $editTags->save();

    $addTag = new Permission();
    $addTag->name         = 'add-tag';
    $addTag->display_name = 'Agregar etiquetas'; // optional
    $addTag->description  = 'Agregar nuevas etiquetas.'; // optional
    $addTag->save();

    $seeUsers = new Permission();
    $seeUsers->name         = 'see-users';
    $seeUsers->display_name = 'Ver usuarios'; // optional
    $seeUsers->description  = 'Ver los usuarios existentes.'; // optional
    $seeUsers->save();

    $editUsers = new Permission();
    $editUsers->name         = 'edit-users';
    $editUsers->display_name = 'Editar usuarios'; // optional
    $editUsers->description  = 'Editar permisos de los usuarios existentes.'; // optional
    $editUsers->save();

    $seeNotImageFiles = new Permission();
    $seeNotImageFiles->name         = 'see-not-image-files';
    $seeNotImageFiles->display_name = 'Ver archivos subidos'; // optional
    $seeNotImageFiles->description  = 'Ver todos los archivos subidos.'; // optional
    $seeNotImageFiles->save();

    $addFilesToPeople = new Permission();
    $addFilesToPeople->name         = 'add-files-to-people';
    $addFilesToPeople->display_name = 'Agregar archivos de asistidos'; // optional
    $addFilesToPeople->description  = 'Agregar archivos y cambiar avatar a los asistidos'; // optional
    $addFilesToPeople->save();

    $seeAllPeople = new Permission();
    $seeAllPeople->name         = 'see-all-people';
    $seeAllPeople->display_name = 'Ver asistidos'; // optional
    $seeAllPeople->description  = 'Ver los asistidos existentes.'; // optional
    $seeAllPeople->save();

    $seeNewPeople = new Permission();
    $seeNewPeople->name         = 'see-new-people';
    $seeNewPeople->display_name = 'Ver nuevos asistidos'; // optional
    $seeNewPeople->description  = 'Ver sólo los nuevos asistidos creados por el usuario.'; // optional
    $seeNewPeople->save();

    $addPerson = new Permission();
    $addPerson->name         = 'add-person';
    $addPerson->display_name = 'Agregar asistidos'; // optional
    $addPerson->description  = 'Agregar nuevos asistidos.'; // optional
    $addPerson->save();

    $editAllPeople = new Permission();
    $editAllPeople->name         = 'edit-all-people';
    $editAllPeople->display_name = 'Editar asistidos'; // optional
    $editAllPeople->description  = 'Editar cualquier asistido del sistema.'; // optional
    $editAllPeople->save();

    $editNewPeople = new Permission();
    $editNewPeople->name         = 'edit-new-people';
    $editNewPeople->display_name = 'Editar nuevos asistidos'; // optional
    $editNewPeople->description  = 'Editar sólo los asistidos creados por el usuario.'; // optional
    $editNewPeople->save();

    $seeAllInteractions = new Permission();
    $seeAllInteractions->name         = 'see-all-interactions';
    $seeAllInteractions->display_name = 'Ver interacciones'; // optional
    $seeAllInteractions->description  = 'Ver las interacciones existentes.'; // optional
    $seeAllInteractions->save();

    $seeNewInteractions = new Permission();
    $seeNewInteractions->name         = 'see-new-interactions';
    $seeNewInteractions->display_name = 'Ver nuevas interacciones'; // optional
    $seeNewInteractions->description  = 'Ver sólo las nuevas interacciones creadas por el usuario.'; // optional
    $seeNewInteractions->save();

    $addInteraction = new Permission();
    $addInteraction->name         = 'add-interaction';
    $addInteraction->display_name = 'Agregar interacción'; // optional
    $addInteraction->description  = 'Agregar nuevas interacciones.'; // optional
    $addInteraction->save();

    $editAllInteractions = new Permission();
    $editAllInteractions->name         = 'edit-all-interactions';
    $editAllInteractions->display_name = 'Editar interacciones'; // optional
    $editAllInteractions->description  = 'Editar cualquier interacción del sistema.'; // optional
    $editAllInteractions->save();

    $editNewInteractions = new Permission();
    $editNewInteractions->name         = 'edit-new-interactions';
    $editNewInteractions->display_name = 'Editar nuevas interacciones'; // optional
    $editNewInteractions->description  = 'Editar sólo las interacciones creadas por el usuario.'; // optional
    $editNewInteractions->save();

    // Add Permisions to Roles
    $admin->attachPermissions(array($seeUsersSearchView, $seeUsers, $editUsers,
                                    $seeTags, $editTags, $addTag, $seeNotImageFiles,
                                    $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                    $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions,$addFilesToPeople));

    $posadero->attachPermissions(array($seeUsersSearchView, $seeUsers,
                                       $seeTags, $seeNotImageFiles,
                                       $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                       $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions,$addFilesToPeople));

    $explorer->attachPermissions(array($seeTags,
                                       $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editAllPeople, $editNewPeople,
                                       $seeInteractionsSearchView, $seeAllInteractions, $seeNewInteractions, $addInteraction, $editAllInteractions, $editNewInteractions,$addFilesToPeople));

    $newUser->attachPermissions(array($seeTags,
                                      $seePeopleSearchView, $seeAllPeople, $seeNewPeople, $addPerson, $editNewPeople,
                                      $seeInteractionsSearchView, $seeNewInteractions, $addInteraction, $editNewInteractions));

}
?>
