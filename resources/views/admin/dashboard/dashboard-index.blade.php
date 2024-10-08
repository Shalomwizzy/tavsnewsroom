@extends('layouts.admin')

@section('content')
            <!-- Sale & Revenue Start -->





            <!-- Analytics Data Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Total Visits</p>
                    <h6 class="mb-0">{{ $analyticsData['activeUsers'] }}</h6>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Page Views</p>
                    <h6 class="mb-0">{{ $analyticsData['screenPageViews'] }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Most Visited Page</p>
                    <h6 class="mb-0">{{ $analyticsData['mostVisitedPage'] }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-dark rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-eye fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Page Views of Most Visited Page</p>
                    <h6 class="mb-0">{{ $analyticsData['mostVisitedPageViews'] }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Analytics Data End -->



            <!-- Analytics Data Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-dark rounded p-4">
                <h5 class="mb-4">Google Analytics Data - Total Visits</h5>
                <canvas id="analytics-chart"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-dark rounded p-4">
                <h5 class="mb-4">Google Analytics Data - Visitors by Country</h5>
                <canvas id="country-visitors-chart"></canvas>
            </div>
        </div>
    </div>
</div>
<!-- Analytics Data End -->


<script>
    document.addEventListener("DOMContentLoaded", function() {
        const analyticsData = @json($analyticsData['analyticsData']);
        const dates = @json($analyticsData['dates']);
        const countryData = @json($analyticsData['countryData']);
        const countries = @json($analyticsData['countries']);

        // Total Visits Chart
        const ctx = document.getElementById('analytics-chart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Total Visits',
                    data: analyticsData,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Visitors by Country Chart
        const ctxCountry = document.getElementById('country-visitors-chart').getContext('2d');
        new Chart(ctxCountry, {
            type: 'bar',
            data: {
                labels: countries,
                datasets: [{
                    label: 'Visitors by Country',
                    data: countryData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
    
    







<!-- Recent Posts with SEO Insights Start -->
<div class="container-fluid pt-4 px-4 seo-insight">
    <div class="text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Recent Posts with SEO Insights</h6>
            <a href="{{ route('seo.index') }}" class="dashboad-showall">Show All</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0 bg-dark ">
                <thead>
                    <tr class="text-white">
                        <th scope="col">Date</th>
                        <th scope="col">Headline</th>
                        <th scope="col">SEO&nbsp;Score</th>
                        <th scope="col">SEO  Suggestions</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentPosts as $post)
                    <tr>
                        <td>{{ $post->created_at->format('Y-m-d') }}</td>
                        <td>{{ $post->headline }}</td>
                        <td>{{ $post->seo_score }}</td>
                        <td>{{ $post->seo_suggestions }}</td>
                        <td><a class="btn btn-sm btn-primary" href="{{ route('seo.analyze', $post->id) }}">Analyze</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Recent Posts with SEO Insights End -->



              <!-- Inbox Messages -->
              <div class="container-fluid pt-4 px-4">
                <div class="row g-4">
              <div class="col-sm-12 col-md-6 col-xl-4">
                <div class="h-100 bg-dark rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h6 class="mb-0 dashboard-h6">Inbox Messages</h6>
                        <a href="{{ route('messages.index') }}" class="dashboad-showall">Show All</a>
                    </div>
                    @foreach ($inboxMessages as $message)
                    @if($message->sender)
                    <div class="d-flex align-items-center border-bottom py-3">
                        <img class="rounded-circle flex-shrink-0" src="{{ asset('images/3d-user.png') }}" alt="" style="width: 40px; height: 40px;">
                        <div class="w-100 ms-3">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-0 message-h6">{{ $message->sender->username }}</h6>
                                <small class="message-created-at">{{ $message->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="message-content">{{ Str::limit($message->message, 50) }}</span>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>






            {{-- CALENDAR START --}}
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-dark rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 dashboard-h6">Calendar</h6>
                    <a href="{{ route('full-calendar') }}" class="dashboad-showall">Show All</a>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
        {{-- CALENDAR END --}}

                    
           {{-- TO DO LIST START --}}
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-dark rounded p-4 to-do-list">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 dashboard-h6">To Do List</h6>
                    <a href="{{ route('todos.index') }}" class="dashboad-showall">Show All</a>
                </div>
                <div class="d-flex mb-2">
                    <form action="{{ route('todos.store') }}" method="POST" class="w-100">
                        @csrf
                        <div class="input-group">
                            <input id="new-task" name="task" class="form-control todo-input bg-dark border-0" type="text" placeholder="Enter task" required>
                            <button type="submit" class="btn btn-primary ms-2">Add</button>
                        </div>
                    </form>
                </div>
                <ul id="tasks-list" class="list-group">
                    @foreach($todos as $todo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <input class="form-check-input me-1" type="checkbox" {{ $todo->completed ? 'checked' : '' }} data-id="{{ $todo->id }}" onchange="toggleTask(this, {{ $todo->id }})">
                            <span class="{{ $todo->completed ? 'text-decoration-line-through' : '' }}" id="task-{{ $todo->id }}">{{ ucfirst($todo->task) }}</span>
                        </div>
                        <button class="btn btn-sm btn-danger" onclick="deleteTask({{ $todo->id }})"><i class="fa fa-times"></i></button>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>



                            <!-- Contact Messages -->
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="h-100 bg-dark rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="mb-0 dashboard-h6">Contact Messages</h6>
                                        <a href="{{ route('contact.index') }}" class="dashboad-showall">Show All</a>
                                    </div>
                                    @foreach ($contactMessages as $message)
                                    <div class="d-flex align-items-center border-bottom py-3">
                                        <img class="rounded-circle flex-shrink-0" src="{{ asset('images/3d-user.png') }}" alt="" style="width: 40px; height: 40px;">
                                        <div class="w-100 ms-3">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-0 message-h6">{{ $message->name }}</h6>
                                                <small class="message-created-at">{{ $message->created_at->diffForHumans() }}</small>
                                            </div>
                                            <span class="message-content">{{ Str::limit($message->message, 50) }}</span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>


  <!-- Share Interactions Start -->
<div class="col-sm-12 col-md-6 col-xl-4">
    <div class="h-100 bg-dark rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="mb-0 dashboard-h6">Share Interactions</h6>
            <a href="{{ route('share-interactions.index') }}" class="dashboad-showall">Show All</a>
        </div>
        <div class="share-interactions-grid">
            @foreach($shareInteractions as $interaction)
                <div class="share-interaction-card">
                    <h5 class="share-interaction-title">{{ $interaction->postNews->headline }}</h5>
                    <p class="share-interaction-platform">Platform: {{ ucfirst($interaction->share_type) }}</p>
                    <p class="share-interaction-count">Count: {{ $interaction->share_count }}</p>
                </div>
                @if (!$loop->last)
                    <hr class="share-interaction-divider">
                @endif
            @endforeach
        </div>
    </div>
</div>
<!-- Share Interactions End -->



                </div>
            </div>
            
            <!-- Widgets End -->




            
    

            <script>
                function toggleTask(checkbox, taskId) {
                    const completed = checkbox.checked;
                    const taskElement = document.getElementById(`task-${taskId}`);
                    if (completed) {
                        taskElement.classList.add('text-decoration-line-through');
                    } else {
                        taskElement.classList.remove('text-decoration-line-through');
                    }
            
                    fetch(`/todos/${taskId}/toggle`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ completed }),
                    });
                }
            
                function deleteTask(taskId) {
                    fetch(`/todos/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                    }).then(() => {
                        location.reload(); // Reload the page after deletion
                    });
                }
            </script>
            
@endsection