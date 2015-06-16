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

?>
