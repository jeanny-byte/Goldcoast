<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index');
    }

    public function about(): void
    {
        $this->view('pages/about');
    }

    public function programs(): void
    {
        $this->view('pages/programs');
    }

    public function gallery(): void
    {
        $this->view('pages/gallery');
    }

    public function donate(): void
    {
        $this->view('pages/donate');
    }

    public function blog(): void
    {
        $this->view('blog/index');
    }

    public function media(): void
    {
        $this->view('media/index');
    }
}
