<?php

return [

    /* Welcome messages */

    'welcome'                   => 'Bienvenido a nuestra aplicación',

    /* Variables para Seeder */

    'locale'                    => 'es_AR',
    'tagsSize'                  => '25',
    'usersSize'                 => '20',
    'peopleSize'                => '120',
    'maxSizeInteractions'       => '15',
    'maxTagsForPeople'          => '5',
    'maxTagsForUsers'           => '5',
    'maxTagsForInteractions'    => '3',
    'maxFavoritesForUsers'      => '20',

    /* Booleans */

    0                           => 'Pendiente',
    1                           => 'Finalizada',

    /* Labels de las views */

    // Menu
    'posaderos'                 => 'Posaderos',
    'posaderos_network'         => 'Red de Posaderos',
    'people'                    => 'Asistidos',
    'interactions'              => 'Interacciones',
    'users'                     => 'Usuarios',
    'reports'                   => 'Listados',
    'peopleReport'              => 'Listado de asistidos',
    'interactionsReport'        => 'Listado de interacciones',
    'usersReport'               => 'Listado de usuarios',
    'newPerson'                 => 'Nuevo asistido',
    'find'                      => 'Buscar',
    'register'                  => 'Registrar',
    'myProfile'                 => 'Mi perfil',
    'editAccount'               => 'Editar cuenta',
    'changePassword'            => 'Cambiar contraseña',
    'derivations'               => 'Derivaciones',
    'favorites'                 => 'Favoritos',
    'login'                     => 'Login',
    'logout'                    => 'Cerrar sesión',

    // Login
    'email'                     => 'Correo electrónico',
    'password'                  => 'Contraseña',
    'remember'                  => 'Recordar correo electrónico',
    'forget'                    => '¿Olvidó su contraseña?',
    'enter'                     => 'Iniciar sesión',

    // Register
    'userName'                  => 'Nombre de usuario',
    'confirmPassword'           => 'Confirmar contraseña',

    // Password
    'restorePassword'           => 'Restablecer contraseña',
    'sendLink'                  => 'Enviar link',

    // Home
    'lastPeopleAdded'           => 'Últimos 10 asistidos agregados',
    'lastInteractionsAdded'     => 'Últimas 10 interacciones agregadas',

    // Derivations
    'pendingDerivations'        => 'Derivaciones pendientes',

    // Paginator
    'prev'                      => '<',
    'next'                      => '>',

    // Emails
    'restorePasswordContent'    => 'Haga click aquí para cambiar su contraseña:',

    // Errors
    'error403'                  => '403 - Acceso denegado',
    'error404'                  => '404 - Archivo no encontrado',
    'error503'                  => '503 - Servicio no disponible',

    // Fileentries
    'saveFilesOf'               => 'Guardar archivos de',
    'maxSizeFile'               => 'El campo filename no puede ser superior a 8 MB.',
    'save'                      => 'Guardar',
    'cancel'                    => 'Cancelar',

    // Interactions
    'saveInteractionWith'       => 'Guardar interacción con',
    'description'               => 'Descripción',
    'date'                      => 'Fecha',
    'interactionState'          => 'Estado de la interacción',
    'pending'                   => 'Pendiente',
    'finished'                  => 'Finalizada',
    'tags'                      => 'Etiquetas',
    'particularDerivation'      => 'Derivación particular',
    'updateInteractionWith'     => 'Actualizar interacción con',
    'photo'                     => 'Foto',
    'person'                    => 'Asistido',
    'state'                     => 'Estado',
    'noInteractions'            => 'No hay ninguna interacción para mostrar.',

    // People
    'savePerson'                => 'Guardar asistido',
    'firstName'                 => 'Nombre',
    'lastName'                  => 'Apellido',
    'dni'                       => 'DNI',
    'birthdate'                 => 'Fecha de nacimiento',
    'gender'                    => 'Sexo',
    'male'                      => 'Hombre',
    'female'                    => 'Mujer',
    'address'                   => 'Dirección',
    'phone'                     => 'Teléfono',
    'observations'              => 'Observaciones',
    'updatePerson'              => 'Actualizar asistido',
    'add'                       => 'Agregar',
    'age'                       => 'Edad',
    'years'                     => 'años',
    'noPeople'                  => 'No hay ningún asistido para mostrar.',
    'addToFavorites'            => 'Agregar a favoritos',
    'removeFromFavorites'       => 'Quitar de favoritos',
    'seePhotos'                 => 'Ver fotos',
    'addPhoto'                  => 'Agregar foto',
    'personAddedBy'             => 'Asistido agregado por',
    'lastUpdate'                => 'Última actualización',
    'lastInteractions'          => 'Últimas interacciones',
    'files'                     => 'Archivos',
    'addFiles'                  => 'Agregar archivos',
    'useAsProfile'              => 'Usar como perfil',
    'photosOf'                  => 'Fotos de',
    'return'                    => 'Volver',

    // Reports
    'exportType'                => 'Tipo de exportación',
    'csvFormat'                 => 'Formato CSV',
    'pdfFormat'                 => 'Formato PDF',
    'xlsFormat'                 => 'Formato XLS',
    'xlsxFormat'                => 'Formato XLSX',
    'interactionsList'          => 'Listado de interacciones',
    'fromDate'                  => 'Desde fecha',
    'toDate'                    => 'Hasta fecha',
    'select'                    => '- Seleccionar -',
    'interactionsWith'          => 'Interacciones con asistido',
    'interactionsCreatedBy'     => 'Interacciones creadas por',
    'download'                  => 'Descargar',
    'createdBy'                 => 'Creados por',
    'peopleList'                => 'Listado de asistidos',
    'peopleCreatedBy'           => 'Asistidos creados por',
    'usersList'                 => 'Listado de usuarios',
    'userRole'                  => 'Tipo de usuario',
    'admin'                     => 'Administrador',
    'posadero'                  => 'Posadero',
    'explorer'                  => 'Samaritano',
    'newUser'                   => 'Nuevo usuario',
    'noUsers'                   => 'No hay ningún usuario para mostrar.',
    'searchError'               => 'Error en la consulta: Falta parámetro de búsqueda',
    'noPeopleResults'           => 'No se han encontrado asistidos que coincidan con su búsqueda.',
    'addPerson'                 => 'Agregar asistido',
    'advancedSearch'            => 'Búsqueda avanzada',
    'search'                    => '¿Búsqueda?',

    // Search
    'maxSearchResultsMessage'   => 'La búsqueda que hizo generó más de 30 resultados. Por favor, refine su búsqueda para que se puedan mostrar los resultados.',

    // Setup
    'schema_missing'            => 'El esquema de la base aun no se ha creado',
    'create_schema'             => 'Crear esquema',
    'schema_created'            => 'El esquema ha sido creado',
    'installation'              => 'Instalación',
    'admin_create_form'         => 'Usuario Administrador',
    'continue'                  => 'Continuar',

    // Tags
    'lastPeople'                => 'Últimos asistidos',
    'addTag'                    => 'Agregar etiqueta',
    'editTag'                   => 'Actualizar etiqueta',
    'tag'                       => 'Etiqueta',
    'noTags'                    => 'No hay ninguna etiqueta para mostrar.',

    // Users
    'updateUser'                => 'Actualizar usuario',
    'lastPeopleAddedBy'         => 'Últimos asistidos dados de alta por',
    'peopleAddedBy'             => 'Asistidos dados de alta por',
    'currentPassword'           => 'Contraseña actual',
    'newPassword'               => 'Nueva contraseña',


    /* Labels de los controllers */

    // AuthController
    'credentialsError'          => 'Estas credenciales no coinciden con nuestros registros.',

    // PasswordController
    'sendPasswordLink'          => 'Link para cambiar la contraseña',

    // FileEntryController
    'noAttachment'              => 'No se adjuntó ningún archivo',
    'fileSaved'                 => 'se ha guardado con éxito.',
    'filesSaved'                => 'se han guardado con éxito.',
    'invalidExtension'          => 'no tiene una extensión válida',

    // InteractionController
    'mailSuccess'               => 'Se ha enviado un mail notificando la derivación del asistido.',
    'mailsSuccess'              => 'Se han enviado los mails notificando la derivación del asistido.',
    'mailFailed'                => 'No se pudo enviar el mail notificando la derivación del asistido.',
    'mailsFailed'               => 'No se han podido enviar los mails notificando la derivación del asistido.',
    'interactionCreated'        => 'Interacción creada.',
    'interactionFailed'         => 'Error al intentar crear la interacción.',
    'interactionUpdated'        => 'Interacción actualizada.',
    'interactionDeleted'        => 'Interacción eliminada.',

    // PersonController
    'personCreated'             => 'Asistido creado.',
    'personFailed'              => 'Error al intentar crear el asistido.',
    'personUpdated'             => 'Asistido actualizado',
    'personDeleted'             => 'Asistido eliminado.',
    'favoriteAdded'             => 'Se agregó el asistido a su lista de favoritos.',
    'favoriteRemoved'           => 'Se quitó el asistido de su lista de favoritos.',

    // ReportController
    'peopleReportName'          => 'ListadoDeAsistidos',
    'interactionsReportName'    => 'ListadoDeInteracciones',
    'usersReportName'           => 'ListadoDeUsuarios',
    'maxRowsForPDF'             => '200',
    'maxRowsForExcel'           => '1000',
    'reportLimitForPDF'         => 'No se pudo generar el PDF porque el rango es demasiado amplio.',
    'reportLimitForExcel'       => 'No se pudo generar el archivo porque el rango es demasiado amplio.',

    // SearchController
    'maxSearchResults'          => '30',
    'noErrorNumber'             => '0',
    'searchErrorNumber'         => '1',
    'maxSearchResultsNumber'    => '2',

    // TagController
    'tagCreated'                => 'Etiqueta creada.',
    'tagUpdated'                => 'Etiqueta actualizada.',
    'tagDeleted'                => 'Etiqueta eliminada.',
    'tagCharacterError'         => 'Las etiquetas sólo pueden contener letras, números o guiones.',
    'repeatedTag'               => 'La etiqueta ya fue cargada en el sistema.',

    // UserController
    'userCreated'               => 'Usuario creado.',
    'userFailed'                => 'Error al intentar crear el usuario.',
    'userUpdated'               => 'Usuario actualizado.',
    'userDeleted'               => 'Usuario eliminado.',
    'oldPasswordMatch'          => 'La contraseña actual es incorrecta.',
    'passwordUpdated'           => 'Contraseña actualizada',

    /* Helpers */

    // Functions
    'derivationMailContent'     => 'Se le ha derivado al asistido ',
    'newDerivation'             => 'Nueva derivación'

];
