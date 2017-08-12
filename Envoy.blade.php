//All of your Envoy tasks should be defined in an Envoy.blade.php file in the root of your 
//project. Here's an example to get you started:

//@servers(['web' => 'root@alive.consciouswebapp.com'])

//@task('foo', ['on' => 'web'])
   // ls -la
//@endtask
//As you can see, an array of @servers is defined at the top of the file, allowing you to 
//reference these servers in the on option of your task declarations. Within your @task 
//declarations, you should place the Bash code that will be run on your server when the task is 
//executed.

//Bootstrapping

//Sometimes, you may need to execute some PHP code before evaluating your Envoy tasks. You may 
//use the @setup directive to declare variables and do general PHP work inside the Envoy file:

@setup
    $now = new DateTime();

    $environment = isset($env) ? $env : "testing";
@endsetup
//You may also use @include to include any outside PHP files:

@include('vendor/autoload.php')

//Confirming Tasks

//If you would like to be prompted for confirmation before running a given task on your   
//servers, you may add the confirm directive to your task declaration:

@task('deploy', ['on' => 'web', 'confirm' => true])
    cd site
    git pull origin {{ $branch }}
    php artisan migrate
@endtask

//Task Variables
//If needed, you may pass variables into the Envoy file using command line switches, allowing // you to customize your tasks:

//envoy run deploy --branch=master
//You may use the options in your tasks via Blade's "echo" syntax:

//@servers(['web' => '162.144.108.187'])

//@task('deploy', 
    //cd site
    //git pull origin {{ $branch }}
    //php artisan migrate
//@endtask

//Multiple Servers
//You may easily run a task across multiple servers. First, add additional servers to your //@servers declaration. Each server should be assigned a unique name. Once you have defined 
// your additional servers, simply list the servers in the task declaration's on array:

@servers(['web-1' => '127.0.0.1', 'web-2' => '127.0.0.1:8000', 'web-3' => '127.0.0.1:8080', 
'web-4' => 'http://127.0.0.1:7000', 'web-5' => '162.144.108.187:2087', 'web-6' => '162.144.108.187', 'web-7' => 'https://consciouswebapp.com', 'web-8' => 'https://www.consciouswebapp.com', 'web-9' => 'http://consciouswebapp.com', 'web-10' => 'consciouswebapp.com', 'web-11' => 'root@alive.consciouswebapp.com', 'web-12' => 'alive.consciouswebapp.com']) 

@task('deploy', ['on' => ['web-1', 'web-2' , 'web-3', 'web-4', 'web-5', 'web-6', 'web-7', 'web-8', 'web-9', 'web-11', 'web-12',]])
   // cd site
    //git pull origin {{ $branch }}
    //php artisan migrate
@endtask
//By default, the task will be executed on each server serially. Meaning, the task will finish 
   // running on the first server before proceeding to execute on the next server.

//Parallel Execution

//If you would like to run a task across multiple servers in parallel, add the parallel option 
//to your task declaration:

//@servers(['web-1' => '192.168.1.1', 'web-2' => '192.168.1.2'])

//@task('deploy', ['on' => ['web-1', 'web-2'], 'parallel' => true])
//    cd site
//    git pull origin {{ $branch }}
//    php artisan migrate
//@endtask

//Task Macros
//Macros allow you to define a set of tasks to be run in sequence using a single command. For 
//instance, a deploy macro may run the git and composer tasks:uncoment what tasks u need below

//@servers(['web' => '192.168.1.1']), ['on' => 'web', 'confirm' => true])

@macro('deploy')
    git
    composer
   @endmacro

  @task('git')
   git pull origin master
   @endtask

   @task('composer')
   composer install
@endtask

//Once the macro has been defined, you may run it via single, simple command:uncomment 
//envoy below to use

//envoy run deploy

//Running Tasks
//To run a task from your Envoy.blade.php file, execute Envoy's run command, passing the 
//command the name of the task or macro you would like to execute. Envoy will run the task and // display
//the output from the servers as the task is running:uncomment runtask to run

//envoy run task