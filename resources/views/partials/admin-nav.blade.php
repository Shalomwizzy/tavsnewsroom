@if(auth()->check() && auth()->user()->isAdmin())
<div class="container-fluid position-relative d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <div class="sidebar pe-4 pb-3">
        <nav class="navbar bg-dark navbar-dark">
            <a href="{{ route('welcome') }}" class="navbar-brand mx-4 mb-3">
                <h1 class="mb-2 mt-n2 display-5 text-uppercase admin-website-name">
                    @php
                        $siteName = \App\Models\WebsiteSetting::getValue('site_name', 'Site Name');
                        // Split the site name into parts
                        $parts = explode(' ', $siteName);
                        // First part in red, rest in black
                        echo '<span style="color: red;">' . $parts[0] . '</span>';
                        if (count($parts) > 1) {
                            echo ' <span style="color: #6C7293;">' . implode(' ', array_slice($parts, 1)) . '</span>';
                        }
                    @endphp
                </h1>
            </a>


            
         
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle object-fit-cover" src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture" style="width: 40px; height: 40px;">
                    <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 admin-name">{{ Str::title(Auth::user()->username) }}</h6>
                    <span>{{ Str::title(Auth::user()->role) }}</span>
                </div>
            </div>

            <div class="navbar-nav w-100">
                <a href="{{ route('admin.dashboard') }}" class="nav-item nav-link active"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>



              
         

                <div>
                    <span class="nav-link admin-span">HOME PAGE</span>
                    <div class="nav-item dropdown">
                
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-house home-fixtures"></i>Home Fixtures</a>
                        <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                            <a href="{{ route('admin.trending-news.index') }}" class="dropdown-item">Select Trending News</a>
                            <a href="{{ route('admin.top-news') }}" class="dropdown-item">Select Top News</a>
                            <a href="{{ route('categories.select_homepage') }}" class="dropdown-item">Select Category</a>
                            <a href="{{ route('admin.carousel.index') }}" class="dropdown-item">Select Carousel News</a>
                            <a href="{{ route('admin.featured_news.index') }}" class="dropdown-item">Select Featured News</a>
                            <a href="{{ route('admin.categoryPostNews.index') }}" class="dropdown-item">Select Categories News</a>
                            <a href="{{ route('admin.popular_news.index') }}" class="dropdown-item">Select Popular News</a>
                            <a href="{{ route('admin.latest_news.index') }}" class="dropdown-item">Select Latest News</a>
                            <a href="{{ route('admin.navbar-items.index') }}" class="dropdown-item">Select Navbar Items</a>
                            <a href="{{ route('admin.social_follows.index') }}" class="dropdown-item">Link Social Media</a>
                            <a href="{{ route('tags.show') }}" class="dropdown-item">Select Tags</a>
                        </div>
                    </div>
                </div>

                <div>
                    <span class="nav-link admin-span">MESSAGE</span>
                    <div class="nav-item dropdown">
                
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-message home-fixtures"></i>Message Fixtures</a>
                        <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                            <a href="{{ route('messages.index') }}" class="dropdown-item">Inbox Message</a>
                            <a href="{{ route('contact.index') }}" class="dropdown-item">Contact Us Message</a>
                        </div>
                    </div>
                </div>




                   {{-- Category --}}
                   <div>
                    <span class="nav-link admin-span"> Categories </span>
                    <div class="nav-item dropdown">
                
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-list home-fixtures"></i>Categories</a>
                        <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                            <a href="{{ route('categories.create') }}" class="dropdown-item">Create Category</a>
                            <a href="{{ route('categories.index') }}" class="dropdown-item">Categories</a>
                        </div>
                    </div>
                </div>
            
                {{-- End Category --}}

                     {{-- POSTNEWS START --}}
                     <div>
                        <span class="nav-link admin-span">POST NEWS</span>
                        <div class="nav-item dropdown">

                          
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-newspaper home-fixtures"></i>Post News</a>
                            <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                                <a href="{{ route('post-news.create') }}" class="dropdown-item">Create Post News</a>
                                <a href="{{ route('post-news.index') }}" class="dropdown-item">All Post News</a>
                                <a href="{{ route('admin.published-news') }}" class="dropdown-item">Published News</a>
                                <a href="{{ route('admin.pending-news') }}" class="dropdown-item">Pending News</a>
                                <a href="{{ route('admin.draft-news') }}" class="dropdown-item">Draft News</a>
                                {{-- <a href="{{ route('admin.top-news') }}" class="dropdown-item">Top News</a> --}}
                             
                            </div>
                        </div>
        
                     </div>

                     {{-- POSTNEWS END --}}



                     <div>
                        <span class="nav-link admin-span">MAIL</span>
                        <div class="nav-item dropdown">

                          
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-newspaper home-fixtures"></i>Mails</a>
                            <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                                <a href="{{ route('admin.subscribers.index') }}" class="dropdown-item">Subscribers List</a>
                                <a href="{{ route('admin.subscribers.create') }}" class="dropdown-item">Mail Subscribers</a>
                                <a href="{{ route('admin.email-settings') }}" class="dropdown-item">Mail Settings</a>
                            
                           
                            </div>
                        </div>
        
                     </div>

                     <div>
                        <span class="nav-link admin-span">ANNOUNCEMENT</span>
                        <div class="nav-item dropdown">

                          
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-newspaper home-fixtures"></i>Anouncements</a>
                            <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                                <a href="{{ route('announcements.create') }}" class="dropdown-item">Announcement Create</a>
                                <a href="{{ route('announcements.index') }}" class="dropdown-item">Announcement List</a>
                                {{-- <a href="{{ route('admin.subscribers.create') }}" class="dropdown-item">Mail Subscribers</a>
                                <a href="{{ route('admin.email-settings') }}" class="dropdown-item">Mail Settings</a> --}}
                            
                           
                            </div>
                        </div>
        
                     </div>



                           <!-- ANALYTICS START -->                           
                     <div>
                        <span class="nav-link admin-span">ANALYTICS</span>
                        <div class="nav-item dropdown">

                          
                            <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-chart-bar home-fixtures"></i>Analytics</a>
                            <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                                <a href="{{ route('share-interactions.index') }}" class="dropdown-item">Share Interaction</a>
                                <a href="{{ route('seo.show') }}" class="dropdown-item">All SEO</a>
                         
                            </div>
                        </div>
                        <!-- ANALYTICS END -->
        
                     </div>



                                           {{-- FOOTER START--}}
                                           <div>
                                            <span class="nav-link admin-span">FOOTER</span>
                                            <div class="nav-item dropdown">
                                        
                                                <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-shoe-prints home-fixtures"></i>Footer Items</a>

                                                {{-- <i class="fa-solid fa-shoe-prints"></i> --}}
                                                <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                                                    <a href="{{ route('admin.footer_settings.index') }}" class="dropdown-item">Social-Media</a>
                                                    <a href="{{ route('tags.show') }}" class="dropdown-item">Tags</a>
                                                    <a href="{{ route('admin.quick_links.index') }}" class="dropdown-item">Quick-Link</a>
                                                    <a href="{{ route('admin.blog-settings.index') }}" class="dropdown-item">Quick-Link-Content</a>
                                               
                                                </div>
                                            </div>
                                        </div>
                                        {{-- FOOTER END --}}

                        {{-- MANAGEMENT START --}}
                     <div>
                        <span class="nav-link admin-span">MANAGEMENT</span>
                        <div class="nav-item dropdown">

                          
                        <a href="#" class="nav-link dropdown-toggle drop-down-write" data-bs-toggle="dropdown"><i class="fa-solid fa-gear home-fixtures"></i>App Settings</a>
                            <div class="dropdown-menu bg-transparent border-0 home-fixtures-items">
                                <a href="{{ route('admin.website-settings.index') }}" class="dropdown-item">Website Settings</a>
                                <a href="{{ route('admin.show.clear.cache') }}" class="dropdown-item">Clear Caches</a>
                                <a href="{{ route('admin.maintenance') }}" class="dropdown-item">Maintenance</a>
                                <a href="{{ route('admin.env.show') }}" class="dropdown-item">Env Settings</a>
                                <a href="{{ route('register.form') }}" class="dropdown-item">Sign Up</a>
                                <a href="{{ route('password.request') }}" class="dropdown-item">Forgot Password</a>
                            </div>
                        </div>
        
                     </div>
                     {{-- MANAGEMENT END --}}
                

                         <br>
 
                <!-- Non-Dropdown Link -->
                <li class="nav-item admin-span">
                    <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                </li>
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->
</div>


  <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand bg-dark navbar-dark sticky-top px-4 py-0">
            <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="fa fa-bars"></i>
            </a>
            <form class="d-none d-md-flex ms-4">
                <input class="form-control bg-dark border-0" type="search" placeholder="Search">
            </form>
            <div class="navbar-nav align-items-center ms-auto">
                <!-- Inbox Messages Dropdown -->
<div class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="position: relative;">
        <i class="fa fa-envelope me-lg-2" style="position: relative;">
            @if($messageCount > 0)
                <span class="badge bg-danger" style="position: absolute; top: -2px; right: -2px; font-size: 0.75rem;">{{ $messageCount }}</span>
            @endif
        </i>
        <span class="d-none d-lg-inline-flex">Inbox Messages</span>
    </a>
    <div class="dropdown-menu dropdown-menu-end bg-dark border-0 rounded-0 rounded-bottom m-0">
        @foreach($inboxMessages as $message)
            @if($message->sender)
                <a href="{{ route('messages.index', ['receiver_id' => $message->sender_id]) }}" class="dropdown-item">
                    <div class="d-flex align-items-center">
                        <img class="rounded-circle" src="{{ asset('images/3d-user.png') }}" alt="Profile Picture" style="width: 40px; height: 40px;">
                        <div class="ms-2">
                            <h6 class="fw-normal mb-0">{{ $message->sender->username }} sent you a message</h6>
                            <small>{{ $message->created_at->diffForHumans() }}</small>
                        </div>
                        @if($unreadMessages->has($message->sender_id))
                            <span class="badge bg-danger ms-2">{{ $unreadMessages[$message->sender_id] }}</span>
                        @endif
                    </div>
                </a>
                <hr class="dropdown-divider">
            @endif
        @endforeach
        <a href="{{ route('messages.index') }}" class="dropdown-item text-center">See all messages</a>
    </div>
</div>


                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="position: relative;">
                        <i class="fa fa-envelope me-lg-2" style="position: relative;">
                            @if($messageCount > 0)
                                <span class="badge bg-danger" style="position: absolute; top: -2px; right: -2px; font-size: 0.75rem;">{{ $messageCount }}</span>
                            @endif
                        </i>
                        <span class="d-none d-lg-inline-flex">Contact Message</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-dark border-0 rounded-0 rounded-bottom m-0">
                        @foreach($recentMessages as $message)
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="{{ asset('images/3d-user.png') }}" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">{{ $message->name }} sent you a message</h6>
                                        <small>{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </a>
                            <hr class="dropdown-divider">
                        @endforeach
                        <a href="{{ route('contact.index') }}" class="dropdown-item text-center">See all messages</a>
                    </div>
                </div>
                
                
                

                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        @if(Auth::user()->profile_picture)
                            <img class="rounded-circle me-lg-2" src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Picture" style="width: 40px; height: 40px;">
                        @else
                            <img class="rounded-circle me-lg-2" src="{{ asset('img/default-user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                        @endif
                        <span class="d-none d-lg-inline-flex">{{ Auth::user()->username }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-dark border-0 rounded-0 rounded-bottom m-0">
                        <a href="{{ route('users.show', Auth::user()->id) }}" class="dropdown-item">My Profile</a>
                        <a href="{{ route('admin.website-settings.index') }}" class="dropdown-item">Settings</a>
                        <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        </nav>

        <style>
        
            .sidebar{
                background-color: black !important;
            }
            
            .admin-top-navbar{
                background-color: black !important; 
            }
                   </style>


      <script>
        //    (function ($) {
        //     "use strict";
        
            // Spinner
            var spinner = function () {
                setTimeout(function () {
                    if ($('#spinner').length > 0) {
                        $('#spinner').removeClass('show');
                    }
                }, 1);
            };
            spinner();
            
          
        
         
        
            // Progress Bar
            $('.pg-bar').waypoint(function () {
                $('.progress .progress-bar').each(function () {
                    $(this).css("width", $(this).attr("aria-valuenow") + '%');
                });
            }, {offset: '80%'});
            
              </script>
        
        @endif
