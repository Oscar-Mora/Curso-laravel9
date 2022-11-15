# Agregado por propietario del Repositorio

## plantillas blade
Al crear plantillas blade, véase carpeta /resources/views/layouts. En ocasiones queremos no reescribir mucho codigo por cada vista entonces usamos blade y sus directivas, explico para que sirven cada una de las más representativas o usadas
- Hacemos referencia a la info que queremos sustituir dentro de los templates con la directiva **@yield('NombreDeLaSeccion/Tag')** ubicadas dentro de las tags html del template, ver plantilla.blade.php del proyecto.
- Cuando queremos que nuestras vistas **hereden** un **contenido** de una plantilla.blade usamos **@extends('ruta.plantilla')** haciendo referencia con lo que hay dentro de los paréntesis a la ruta de la plantilla que queremos implementar, poniendo ésta directiva al inicio del archivo de la vista que está heredando el formato de la plantilla.blade
- Despues ya que hicimos el extend con su ruta, para usarla dentro de la vista que hereda la plantilla-balde, hay que usar las directivas **@section('NombreDeReferenciaContenido','ContenidoQueSustituye')** que sustituye lo que pusimos predeterminado en la section con el nuevo contenido que reemplazará la referencia, **ver plantilla.blade.php y home.blade.php del proyecto** . A demás podemos usar **@section('NombreDelSection') y   @endsection** para delimitar limites de una seccion y poner todo el contenido que sea necesario entre estas 2 directivas,por ejemplo tags HTML, variables u otras directivas de blade para rellenar la seccion.

## DATABASE

Creo que lo más importante aquí es que se revise el archivo database.php en la carpeta config de la carpeta root junto con el archivo .env o .env.example en caso de estar bajando el repositorio despues de haber sido creado

## Migraciones
Son como el control de versiones dentro de las bases de datoslo que permitre al equipo modificar y compartir el esquema de la base de datos de la aplicacion.Cada modificacion que querramos hacer en la DB van a quedar como un registro en las migraciones y todos esos registros van a estar al alcance de mis compañeros de equipo en el pryecto
- Si vamos a la carpeta database dentro de ella vemos una carpeta llamada migrations
por defecto tenemos 3 migraciones
el contenido dentro de ellas es, que veremos una clase CreateUsersTable dentro del file create_users_table.php
- Dentro del metodo CreateUsersTable que se extiende de la clase Migration, tenemos 2 metodos el metodo up y el metodo down
### - Dentro del metodo up 
vemos que se está ejecuntando un metodo create de la clase Schema, que va a recibir como parametro una cadena(que es el nombre de la tabla que se va a crear entre '') y como segundo parametro se recibe una function anónima, que a su vez recibe como parametros un objeto "$table" de tipo Blueprint. 
- Y para que queremos este objeto, pues cuenta con metodos definidos y se utiliza para crear las columnas de nuestras tablas.
> Al llamar al metodo id() del objeto $table crea una nueva columna con las siguientes propiedades:
- Integer Unsigned Increment
- Si no se le asigna un nombre entre los parentesis, se le asigna el nombre 'id' a esa columna
> Cuando ejecute el metodo string() del obj-$table lo que va a hacer es agregar una nueva columna y le va a asignar el tipo de dato varchar y la cantidad de datos que permite almacenar por default es de 255, pero podemos ponerle menos entre los parentesis, pero primero debemos especificar el nombre y luego el limite de caracteres que permitirá.
> Cuando usamos el metodo text() nos permitirá usar más de 255 caracteres, tambien se le pasan entre parentesis, el nombre de la columna y la cantidad de caracteres
> Cuando usamos string('email')->unique() hará que a nivel de DB no se repitan registros con el mismo tipo de dato y el campo se llamará email
> Cuando utilizamos el metodo timestamp('email_verified_at')->nullable(); verifica que sea un correo electrónico y a su vez registra la hora de la verificacion del email, y la propiedad nullable() es porque con esa propiedad el campo va a quedar vacío a la hora del registro, siempre que incluyamos un campo que pueda quedar vacio tenemos que pasarle la propiedad nullable.
>cuando usamos el tipo de metodo rememberToken(), tambien crea una columna varchar pero tamaño 100, le dará el nombre de remembertoken sin que le pasemos parametros, genera un token cada vez que el usuario de click en mantener sesion iniciada
> Cuando usamos el metodo timestamps() crea 2 columnas created_at y updated_at con la fecha y hora en que se creo y o edito un registro
### - Dentro del metodo down 
Vemos como se crea  un metodo de la clase schema dopIfExist('users') pasando como parametro el nombre de la tabla.

### - Buenas practicas con migraciones
- hacer siempre php artisanmake:migration create_nombreS_table para que cree los metodos y todo sea por la convencion con la que laravel genera las migraciones

## ¿Como hacer migraciones sin sobre escribir o Borrar datos ya existentes?
1. Generamos registros en la base de datos.

2. generamos una migracion siendo lo mas descriptivos posibles "php artisan make:migration add_avatar_to_users_table"

**NOTA 1**: En la sentencia final del punto 2 *"add_avatar"* hace referencia a la accion que estamos creando; *"_to_users_table"* es una convencion que se usa como cuando creamos tablas *"create_"*antes y *"_table"* despues; entonces lo que hace es crear una migration con codigo ya escrito, que hará referencia la clase **Schema::** y con un metodo ya no *create* como cuando creamos tablas, sino que llama al metodo **_"table"._**. Si queremos especificar su posicion en la tabla podemos usar los metodos ->after('nombreColumna') y el nombre de la columna dentro como string o ->before()
**"_¿Cuando queremos llamar el metodo table?_"** Cuando queremos modificar una tabla que ya existe, éste metodo recibe como parametros, el nombre de la tabla que queremos modificar y una funcion anónima  con un parametro de tipo objeto blueprint de nombre _$table._ Aquí debemos definir las modificaciones que queremos hacer a la tabla.
**NOTA 2**: Cuando hacemos migraciones y estamos agregando nuevas columnas a tablas que ya tienen registros creados, entonces tenemos que pasar el metodo **nullable()** a las nuevas columnas ya que de lo contrario los registros ya existentes que reciban esa nueva columna devolverían error porque no se pueden llenar con nada entonces con nullable se pone un valor null por defecto dentro de las nuevas columnas a menos que se especifique manualmente en cada registro, es por eso el motivo de la funcion *nullable().*
**NOTA 3**: dentro de la nueva migracion para AGREGAR NUEVA COLUMNA tambien deberíamos agregar el metodo DOWN( ) llamando al objeto $table->dropColumn('avatar') refiriendo a que haga el drop de todo lo que especificamos que modifique dentro de su metodo up().

3. ya que especificamos las modificaciones en los metodos up() y down() de la migracion corremos la migracion con **_php artisan migrate_**

4. **¿Y que hago si me equivoque en algo de lo que especifiqué?**
Es tan sencillo como hacer **_php artisan migrate:rollback;_** (regresa la ultima migracion hecha). 
Generas las modificaciones de correccion y enseguida vuelves a correr **_php artisan migrate_** 

5. **¿Y si quiero hacer otra nueva Modificacion?**
- En la documentacion explica como, pero **lo principal es** 
_descargar doctrine/dbal_ -> **_composer require doctrine/dbal_** [Migration Columns](https://laravel.com/docs/9.x/migrations#modifying-columns)
Y ya instalado es  generar la migracion (VERSION DE MODIFICACION DE LA DB) con 
**php artisan make:migration cambiar_propiedades_to_users_table** la ultima parte del comando difiere de la accion y la tabla; ya despues es seguir los pasos de las siguientes ligas, que sería especificar la banderá ->change(); al final de las nuevas modificaciones 
**NOTA:** las modificaciones se establecen en up()
**PERO en  down() SIEMPRE van las propiedades que habían antes** de las modificaciones, por ejemplo si el campo 'name' tenía varchar(255) eso debe tener down() con el metodo ->change();en cambiar_propiedades_to_users_table.php, para REVERTIR los cambios BIEN en caso de hacer "**rollback**".
[Updating Column Attributes](https://laravel.com/docs/9.x/migrations#updating-column-attributes)
[Renaming Columns](https://laravel.com/docs/9.x/migrations#renaming-columns)

# Models
Para crear modelos usamos php artisan make:model Curso
Los modelos se declaran en singular
Para poder usar modelos podemos hacer de distintas formas, una de ellas e susar tinker
## [Tinker](https://laravel.com/docs/9.x/artisan#usage) 
php artisan tinker
Ejecuta el tinker de Eloquent, que permite ejecutar comandos o scripts desde terminal
 al ejecutar el tinker recibimos su prompt 
 "">   "" y una vez entrando, eloquent trata a cada uno de los registros como si fuera un nuevo objeto
 por ejemplo al hacer en el prompt de tinker:
 podemos llamar una instancia de un modelo "use App\Models\Curso;
 Y generar una nueva variable que cree una instancia del model "$curso = new Curso;
 y despues asignar valores a sus propiedades $curso->name='Laravel';
 $curso -> description = 'El mejor framework de php';
 Y guardar sus registros en la base de datos con el metodo save()  "$curso->save();"
 Llenaría los datos de created_at y updated_at en la base d datos.

 # Seeders
 En esta version se borró las migraciones de edicion de bases de datos y ademas se resetearon los datos de las tablas y se agregó una columna en la tabla cursos, categoria.

- Para hacer uso los Seeders o semillas podemos instanciar un modelo dentro del archivo DatabaseSeeders.php con use (App\Models\NombreModel) y luego, dentro del metodo run() de la clase DatabaseSeeder de éste archivo agregamos una $variable  que instancíe al modelo que vamos a usar(new Curso) y despues le generaríamos la data que queremos que guarde para al final pasarle el metodo save() a la variable y que se guarde en la BD por cada campo ej.($curso->name='laravel'...etc)  y luego $curso->save();.Ésta sería la forma más manual de hacer la inserción de semillas

- Otra forma es usar el comando php artisan make:seeder NombreSeeder 
De éste modo en un archivo aparte separamos por tipo de Use model(llamar al modelo con use) y cantidad de seeders(la instancia de modelo, descripcion de campos y save() por cada registro);esto anterior para cada nuevo archivo Seeder. Para esto en el archivo main de Seeders _(DatabaseSeeder.php)_ dentro de su metodo run() llamamos al seeder hijo de la tabla que vamos a inyectar de info ej. 
$this->call(CursoSeeder::class);

# Factory 
Para trabajar con Factories podemos hacer el commando sail php artisan make:factory CursoFactory --model=Curso
Haciendo referencia en el flag --model=Model al modelo que se usará de referencia, osea la create_model_table.php del modelo para poder simplemente llamar al modelo desde DatabaseSeeder.php con Curso::factory(50)->create();
y despues en el modelo  declarar que hace uso de un factory con use Illuminate\Database\Eloquent\Factories\HasFactory; y con  use HasFactory;

# SINTAXIS FUNCIONES FLECHA, implementadas desde [php7.4](https://www.php.net/manual/es/functions.arrow.php)

# MUTADORES Y ACCESORES  (SETTERS Y GETTERS)
Para hacer un mutador y un accesor debemos identificar el Model que queremos preparar para tenga mutadores y accesores
Así que tenemos que importar en la parte de arriba una "definicion" llamada "Attribute", (use Illuminate\Database\Eloquent\Casts\Attribute;) y tenemos que agregar despues dentro de la class User generamos un metodo protected con el nombre del atributo del modelo.
Y dentro del modelo pediremos que nos retorne una nueva instancia del Attribute osea:
>  protected function name():Attribute{return new Attribute()} 
y dentro del los parentesis del new Attribute se colocarán el mutador , (set) y el accesor(get).
ver ejemplo de model User, los mutadores y accesores fueron definidos con forma funcion flecha y primero(lo que está comentado) mediante funcion anónima.

# GENERANDO EL CRUD
## Crear listado y mostrar un registro

Para la Generacion del CRUD Iniciamos con "ASIGNACION DEL NOMBRE DE RUTA" desde web.php ver comentario NOMBRE DE RUTA 
Generamos primero Index, que devuelve:
1. Renderizado del listado de registros existentes en base de datos
2. Renderiza la paginación de los registros en la base de datos
3. Renderiza botón de Crear Registro
4. Enlace para renderizar cada uno de los registros
- Así que en el metodo index() del Controller podemos generar una $variable que cache del modelo todos los registros --> Model::all();<-- y en la vista correspondiente a la que apunta la ruta de web.php podemos poner en una @seccion de blade lo siguiente _<ul>@foreach($cursos as $curso) <li>{curso->name} </li> @endforeach</ul>_ para mostrar la prop nombre,
- Para hacer bien la paginacion deberíamos agregar los botones despues del listado  cambiando en el controller al cachar los datos de la BD _Model::paginate();_ que devuelve por páginas todos los registros y en la vista, con el siguiente codigo _{{$cursos->links()}}_ laravel nos ayuda a hacer el diseño de las paginaciones
- La siguiente tarea es generar el boton de crear curso con un _<a href="{{route('route.nameAssigned')}}"></a>_ al inicio de la vista, que debería llevar la ruta de nombre asinado 'curso.create'
- Por último  se debe generar el enlace que debe ir en cada registro para que al dar click nos lleve a visualizar la data de cada registro._<a href="{{route('cursos.show',$curso->id)}}">{{$curso->name}}</a>_ que debe llevar la ruta y el argumentopara mandar al back

## Crear y actualizar registros
El siguiente paso es modificar el template de create.blade.php agregando el Form con su action(la ruta que se invoca) y method(el m http que se usa) _<form action="{{route('cursos.store')}}" method = "POST">_ Y con sus inputs y sus atributo name='nombreCampoEnBD' para poder guardar esa informacion en la bd.
Luego se generan las rutas post en el archivo web.php _Route::post('cursos/',[CursoController::class,'store'])->name('cursos.store');_ que definen el metodo http, la ruta que devuelve y el metodo que hara la lógica con la informacion que se esté tratando.Y luego se hace la lógica en los metodos del controllador(store y update edit)
 ### Metodo store
 Para recibir en un metodo del controller lo que se envía por formularios del frontend se necesita pasar como parametro un objeto de tipo Request con nombre $request, al hacer esto cualquier cosa que se envíe por el formulario  va a estar almacenado en éste objeto y podemos probarlo pidiendo que devuelva todo su contenido con return $request->all();
 Entonces ya que confirmé que recibo datos, instancío el modelo de la bd donde quiero guardar la información _$curso = new Curso();_  y despues mapeo cada dato pasandolo al backend, ejemplo: _$curso->name = $request->name;_ y así por cada campo. Luego de mapear puedo testear la data con _return $curso;_ o _dd($curso);_
 Después ya que verifiqué que tengo el resultado que quiero puedo guardar ahora si la info en BD con _$curso->save();_
 Y por último se pide al controllador que despues de guardar nos redireccione a la vista principal o a la vista del nuevo registro con el metodo redirect();
 _return redirect()->route('cursos.show',$curso);_
 ## Metodo Actualizar
 Tenemos que crear ahora un botón dentro del registro que estémos visualizando y que nos permita editar el registro. Es muy Importante! el mandar parametros cuando se requiera, en este caso los pasos a seguir son:
 - Generar la ruta en web.php _Route::get('cursos/{id}/edit','edit')->name('cursos.edit');_ _Route::get_ hace referencia a ruta, metodo del controlador y su nombre asignado que usaremos en la vista.
 - Generamos el metodo en el controller, el cual recibe un parametro que se estableció en la ruta de _web.php_ **_{$id}_** con _public function edit($id){ ..codigo}_
 - Generamos la referencia a la ruta de la vista de modificacion del registro, en la vista donde queremos generar la funcionalidad, ya sea en el listado principal o en la vista del mismo registro.Mediante un botón o enlace <a> con su _href="{{route('cursos.edit',$curso->id)}}">_ mandando el parametro y la ruta a buscar.
- Despues generamos la lógica de lo que haremos en el controlador. Si en los parametros de la funcion de edit le pasamos por ejemplo un objeto de tipo Curso hacemos referencia al modelo,y llamado $id o $curso como quedó en el ejemplo ya podríamos hacer uso de la data que estamos trayendo del front y mandarla a la vista donde modificaremos el registro _return view('cursos.edit', compact('curso'));_  
# Actualizacion de Datos
- Generamos ahora la vista de actualizacion de datos,como un Forms que mapee la info de la variable que recibe(ver punto anterior). ahi los atributos del form serían:
 _action="{{route('cursos.udpate')}}" method = "POST">_ y se le pasa una directiva de blade para cambiar el metodo pues es PUT con @methods('put')
- Ahora generamos la ruta en web.php  _Route::put('cursos/{curso}',[CursoController::class,'update'])->name('cursos.update');_
- Despues hacemos el metodo en Controller, rescatando lo que esta mandando por la url con un objeto Request llamado $request y un objeto tipo Curso llamado $curso pra que lo que obtengo del usuario en el formulario lo meta en el $curso  y al final guardamos con ->save();
- Finalmente  hacemos un redirect para ir al registro de nuevo pero actualizado con lo que nos dió el user.
# Validaciones
1. el metodo que se usa se llama validate(); y se pone con  los campos=>required, para que no permita avanzar si esos campos no estan fulfilled.
2. ir a la vista y poner la directiva @error de blade ver create.blade.php
 profundizar más con: 
 - [tutorial-1](https://www.youtube.com/watch?v=KbpbqZshUus&list=PLZ2ovOgdI-kWWS9aq8mfUDkJRfYib-SvF&index=21)
 - [tutorial-2](https://www.youtube.com/watch?v=Ze-Sg2BT3mc&list=PLZ2ovOgdI-kWWS9aq8mfUDkJRfYib-SvF&index=22)


# Asignacion Masiva de Store
Aquí hablamos sobre las formas de asignar valores recibidos en fronted en los formularios a campos en la BD
1. Primer Forma: Asignacion masiva
$curso = Curso::create($request->all());
 Aquí se crea un nuevo objeto desde lo que recibimos del front en $request, pero necesita que se cree una propiedad fillable() en el Model por cada campo, para que permita rellenar un registro por asignacion masiva solo de lo que establecimos en la propiedad $fillable, ver class del Curso.php en /Models
 con la propiedad $ guarded=['nombre del campo'] podemos resguardar los campos que de plano no podrán sobreescribir o escribir los usuarios, y así estaŕa más limpio el modelo para lo de asignacion masiva
# Asignacion Masiva de Update

2. $curso-> update($request->all()); justo hace lo mismo que el metodo create();