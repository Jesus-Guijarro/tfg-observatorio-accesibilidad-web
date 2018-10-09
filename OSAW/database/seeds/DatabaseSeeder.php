<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call( RolsTableSeeder ::class );
        $this->command->info('Semilla USER' );

        $this->call( UsersTableSeeder ::class );
        $this->command->info('Semilla USER' );

        $this->call( CategoriasTableSeeder ::class );
        $this->command->info('Semilla USER' );

        $this->call( SitiosTableSeeder ::class );
        $this->command->info('Semilla USER' );

        $this->call( PaginasTableSeeder ::class );
        $this->command->info('Semilla USER' );

    }
}
