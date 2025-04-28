<?php
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Example data to pass to the view
        $data = [
            'title' => 'Welcome to Your PHP Project',
            'message' => 'Hello World!'
        ];
        
        // Return data to be used in the view
        return $data;
    }
}
?>