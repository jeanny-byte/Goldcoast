<?php
require_once 'db_config.php';
if($conn){
    echo "Database connection successful";
} else {
    echo "Database connection failed";
}
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goldcoast Literacy Program</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Barlow:wght@400;700&family=Baloo+Thambi+2:wght@400;700&display=swap" rel="stylesheet">

</head>


<body class="min-h-screen flex flex-col">

    <div class="flex-grow">
        <div class="nav-container">
            <nav class="navbar">
                <div class="logo"><a href="index.php"><img src="images/GLP_logo.png" alt="logo"></a></div>
                <div class="nav-links">
                    <a href="projects.html">Projects</a>
                    <a href="about.html">About Us</a>
                    <a href="gallery.html">Gallery</a>
                    <a href="donate.html">Get Involved</a>
                </div>
                <button class="donate-btn btn">Donate</button>
                <button class="hamburger" aria-label="Toggle menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </nav>
        </div>

        <div class="side-drawer" id="sideDrawer">
            <a href="projects.html">Programs</a>
            <a href="about.html">About Us</a>
            <a href="gallery.html">Gallery</a>
            <a href="donate.html">Get Involved</a>
        </div>

        
        <!--Hero section-->
        <div class="bg-white ">
        <div id="hero" class="min-h-screen flex flex-col items-center justify-center text-center p-4 opacity-0 transition-opacity duration-1000">
            <p class="text-sm md:text-base lg:text-lg mb-2 text-gray-600 font-baloo">
                Enhancing and increasing child literacy
            </p>

            <script src="https://cdn.tailwindcss.com"></script>

<div class="bg-white">
  
  <div class="relative isolate px-6 pt-14 lg:px-8">
    <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
      <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
    <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">
      <div class="hidden sm:mb-8 sm:flex sm:justify-center">
        <div class="relative rounded-full px-3 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20">
          Announcing our next upcoming projects. <a href="#" class="font-semibold text-indigo-600"><span class="absolute inset-0" aria-hidden="true"></span>Read more <span aria-hidden="true">&rarr;</span></a>
        </div>
      </div>
      <div class="text-center">
        <h1 class="text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl">Goldcoast Literacy Program</h1>
        <p class="mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat.</p>
        <div class="mt-10 flex items-center justify-center gap-x-6">
          <a href="#" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get started</a>
          <a href="#" class="text-sm/6 font-semibold text-gray-900">View More<span aria-hidden="true">→</span></a>
        </div>
      </div>
    </div>
    <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
      <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
    </div>
  </div>
</div>

            <!-- <h1 class="text-lg text-4xl md:text-6xl lg:text-7xl font-bold mb-3 text-navy-blue font-paytone tracking-tight">
                GOLDCOAST
            </h1>
            <p class="text-xl md:text-2xl lg:text-3xl mb-1 text-gray-800 font-barlow font-bold tracking-wide">LITERACY</p>
            <p class="text-lg md:text-xl lg:text-2xl mb-8 text-gray-800 font-baloo">PROGRAM</p> -->
            <svg xmlns="http://www.w3.org/2000/svg" class="animate-bounce w-12 h-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <a href="#Achievements"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></a>
            </svg>
        </div>
        </div>

        <!--Blog Section-->
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
              <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-pretty text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">From the blog</h2>
                <p class="mt-2 text-lg/8 text-gray-600">Learn how to grow your business with our expert advice.</p>
              </div>
              <div class="mx-auto mt-10 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-16 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <article class="flex max-w-xl flex-col items-start justify-between">
                  <div class="flex items-center gap-x-4 text-xs">
                    <time datetime="2020-03-16" class="text-gray-500">Mar 16, 2020</time>
                    <a href="#" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">Marketing</a>
                  </div>
                  <div class="group relative">
                    <h3 class="mt-3 text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                      <a href="#">
                        <span class="absolute inset-0"></span>
                        Boost your conversion rate
                      </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm/6 text-gray-600">Illo sint voluptas. Error voluptates culpa eligendi. Hic vel totam vitae illo. Non aliquid explicabo necessitatibus unde. Sed exercitationem placeat consectetur nulla deserunt vel. Iusto corrupti dicta.</p>
                  </div>
                  <div class="relative mt-8 flex items-center gap-x-4">
                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-50">
                    <div class="text-sm/6">
                      <p class="font-semibold text-gray-900">
                        <a href="#">
                          <span class="absolute inset-0"></span>
                          Mad. G
                        </a>
                      </p>
                      <p class="text-gray-600">Founder</p>
                    </div>
                  </div>
                </article>
          
                <!-- More posts... -->
              </div>
            </div>
          </div>
          
          <!--Testimonials-->
<div class="bg-white py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
      <h2 class="text-center text-lg/8 font-semibold text-gray-900">Sponsored and Partnerd by trusted brands around the world</h2>
      <div class="mx-auto mt-10 grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-5">
        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/plus/img/logos/158x48/transistor-logo-gray-900.svg" alt="Transistor" width="158" height="48">
        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/plus/img/logos/158x48/reform-logo-gray-900.svg" alt="Reform" width="158" height="48">
        <img class="col-span-2 max-h-12 w-full object-contain lg:col-span-1" src="https://tailwindui.com/plus/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple" width="158" height="48">
        <img class="col-span-2 max-h-12 w-full object-contain sm:col-start-2 lg:col-span-1" src="https://tailwindui.com/plus/img/logos/158x48/savvycal-logo-gray-900.svg" alt="SavvyCal" width="158" height="48">
        <img class="col-span-2 col-start-2 max-h-12 w-full object-contain sm:col-start-auto lg:col-span-1" src="https://tailwindui.com/plus/img/logos/158x48/statamic-logo-gray-900.svg" alt="Statamic" width="158" height="48">
      </div>
    </div>
  </div>
          
        <!--Achievement Section-->
        <div class="Achievements_Section" id="Achievements">
            <div id="counter-section" class="w-full max-w-4xl mx-auto p-4 opacity-0 transition-opacity duration-1000">
                <div class="rounded-lg shadow-xl mb-5">
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="flex flex-col items-center justify-center text-white text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                <h3 class="text-sm md:text-base lg:text-lg font-bold mb-2">Achievements</h3>
                                <span class="text-4xl font-extrabold" data-target="150">0</span>
                            </div>
                            <div class="flex flex-col items-center justify-center text-white text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <h3 class="text-sm md:text-base lg:text-lg font-bold mb-2">Communities Reached</h3>
                                <span class="text-4xl font-extrabold" data-target="50">0</span>
                            </div>
                            <div class="flex flex-col items-center justify-center text-white text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <h3 class="text-sm md:text-base lg:text-lg font-bold mb-2">Kids Helped</h3>
                                <span class="text-4xl font-extrabold" data-target="10000">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            
        </div>
        </div>
    </div>

    <!--Footer-->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">About Us</h3>
                    <p class="text-gray-400">Goldcoast Literacy Program is hoping for an illiteracy free world where we wish for every child learn how to read and having whiles doing.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Our Programs</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Get Involved</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Donate</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>Accra, Ghana</li>
                        <li><i class="fas fa-phone mr-2"></i>+233 (27) 360 5996</li>
                        <li><i class="fas fa-envelope mr-2"></i>contact@golcoastliteracyprogram.org</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-4">Newsletter</h3>
                    <form id="newsletter-form" class="space-y-2">
                        <input type="email" placeholder="Your email" class="w-full px-3 py-2 bg-gray-700 text-white rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <button type="submit" class="w-full hover:bg-blue-600 text-black font-semibold py-2 px-4 rounded transition duration-300 btn">Subscribe</button>
                    </form>
                </div>
            </div>
            <hr class="my-8 border-gray-700">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 mb-4 md:mb-0">
                    &copy; 2023 GCLP-NGO | Powered By Dcom Technology Ltd.
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white transition duration-300"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <button id="back-to-top" class="fixed bottom-4 right-4 bg-blue-500 text-white p-2 rounded-full shadow-lg opacity-0 transition-opacity duration-300">
        <i class="fas fa-arrow-up"></i>
    </button>

<script src="script.js"></script>
</body>
</html>
