<?php
namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use App\Notifications\TenantCreated;
use Hyn\Tenancy\Database\Connection;
use Illuminate\Notifications\Notifiable;

class CreateTenant extends Command
{
    use Notifiable;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Easily create new tenant with redirect, https, maintenance options. Also with an administrator account.';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create';

    /**
     * Application base URL.
     *
     * @var string
     */
    private $baseURL;

    /**
     * Database connection
     *
     * @var string
     */
    private $connection;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->baseURL = config('app.url_base');

        $this->connection = app(Connection::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Provide information to create new tenant.');

        $fqdn = $this->fqdn();
        $redirect = $this->redirect();
        $https = $this->forceHttps();
        $maintenance = $this->underMaintenance();
        $username = 'admin';
        $email = $this->value('administrator email');
        $adminPassword = $this->value('administrator password (leave blank to)', true, str_random());

        if (!$this->confirmData($fqdn, $redirect, $https, $maintenance, 'admin', $email)) {
            $this->error('Process terminated.');
            return false;
        }

        $this->info('Creating tenant, please wait...');
        $this->output->progressStart(2);
        $subdomain = $fqdn . '.' . $this->baseURL;
        $website = Tenant::registerTenant($subdomain, $redirect, $https, $maintenance);

        $this->connection->set($website);
        $this->output->progressAdvance();

        Tenant::registerAdmin($adminPassword, $email)->notify(new TenantCreated($subdomain));
        $this->output->progressFinish();

        $this->info('Tenant created!');
        $this->info("Tenant address: {$fqdn}.{$this->baseURL}");
        $this->info("Administrator sign in, using password: {$adminPassword}");
        $this->info("Administrator has been invited!");
    }

    /**
     * @param $fqdn
     * @param $redirect
     * @param $https
     * @param $maintenance
     * @param $username
     * @param $email
     */
    private function confirmData($fqdn, $redirect, $https, $maintenance, $username, $email)
    {
        $this->info('Tenant information');
        $this->info('------------');
        $this->info("Tenant FQDN: {$fqdn}.{$this->baseURL}");
        if ($redirect) {
            $this->info("Redirect: {$redirect}");
        }

        if ($https) {
            $this->info("Force HTTPS: {$https}");
        }

        if ($maintenance) {
            $this->info("Under maintenance: {$maintenance}");
        }

        $this->info('');
        $this->info("Administrator username: {$username}");
        $this->info("Administrator email: {$email}");

        if ($this->confirm('Do you want to create a tenant with this data?')) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function forceHttps()
    {
        if ($this->confirm('You do want to force https?')) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    private function fqdn()
    {
        $value = $this->ask('Please enter tenant name');

        if (Tenant::tenantExists($value)) {
            $this->error("Tenant '{$value}.{$this->baseURL}' already exists, please choose another name.");

            return $this->fqdn();
        }

        if (empty($value)) {
            $this->error('Tenant name cannot be empty.');

            return $this->fqdn();
        }

        return $value;
    }

    /**
     * @return bool|string
     */
    private function redirect()
    {
        if ($this->confirm('You do want to redirect this tenant?')) {
            $value = $this->ask('Please enter where you want to redirect (ex.: http://tenant.example.com)', false);

            return $value;
        }

        return false;
    }

    /**
     * @return bool|string
     */
    private function underMaintenance()
    {
        if ($this->confirm('Is tenant under maintenance?')) {
            $value = $this->ask('Since when? Please provide full date and time (ex.: 2018-01-01 12:00:00)');

            return $value;
        }

        return false;
    }

    /**
     * @param  $name
     * @return string
     */
    private function value($name, $secret = false, $default = null)
    {
        $value = null;
        if  ($secret) {
            $rawValue = $this->secret("Please enter {$name}");
            $value = strlen(trim($rawValue)) === 0 ? $default : $rawValue;
        } else {
            $value = $this->ask("Please enter {$name}", $default);
        }

        if (empty($value)) {
            $this->error("{$name} cannot be empty.");

            return $this->value($name);
        }

        return $value;
    }
}
