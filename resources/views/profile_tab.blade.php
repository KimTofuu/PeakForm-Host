<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
  <style>body{overflow-y: hidden;}</style>
</head>
<body>
  <div id="loader-wrapper" style="position:fixed;top:0;left:0;width:100vw;height:100vh;z-index:9999;background:#111;display:flex;align-items:center;justify-content:center;">
    <img src="{{ asset('images/logo_6.png') }}" alt="Loading..." class="dumbbell-loader" style="width:150px;height:150px;">
  </div>
  <div class="container">
   <div class="burger-menu" onclick="toggleSidebar()"></div>
<aside class="sidebar">
  <div class="close-btn" onclick="toggleSidebar()"></div>
      <div class="profile-section">
        <img src="images/logo_8.png" class="avatar">
        <p class="name"  style="font-family: 'Michroma', sans-serif; color:#fafafa;" >{{$user->Fname}} {{$user->Lname}}</p>
        <hr />
      </div>
      <nav class="nav-menu">
        <a href="{{ route('overview_tab') }}">Overview</a>
        <a href="{{ route('progress_tab') }}">Progress</a>
        <a href="{{ route('workouts_tab') }}">Workouts</a>
        <a href="{{ route('mealplan_tab') }}">Macros</a>
        <a class="active" href="{{ route('profile_tab') }}">Profile</a>
        <a href="{{ route('timer_tab') }}">Timer</a>

      </nav>
      <div class="logout">
        <div class="logout">
          <form method="GET" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
              <img src="images/log_out2.png" alt="Log Out">
            </button>
          </form>
        </div>
    </aside>

  <main class="main-content">
      <div class="cards">
    
        <div class="first-side">
          <div class = "daily_tab_prof" style="align-items: start; text-align: left;">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" > Account </h2>
            </div>
            <div class = "workout_content" style="color:white; align-items: left;">
              <p style="opacity: 50%; font-size: 1rem;"> Name </p>{{ optional($user)->Fname }} {{ optional($user)->Lname }}
            </div>

            <div class = "workout_content" style="color:white; text-align:left;">
              <p style="opacity: 50%; font-size: 1rem;"> Email Address </p> {{ optional($user)->email }}
            </div>

            <div class = "workout_content" style="color:white; text-align:left;"> 
              <p style="opacity: 50%; font-size: 1rem;"> Password </p> ************
            </div>
          </div>

          <div class="actions">
            <div class = "actions_3">
              <a onclick="document.getElementById('editModal').classList.remove('hidden')"  class="btn play"> 
                <button> Change Password </button>
              </a>
            </div>
          </div>
        </div>

        <div class="second-side">
          <div class = "daily_tab_prof" style="align-items: start; text-align: left;">
            <div class = "header_content">
              <h2 style="font-family: 'Michroma', sans-serif;" > Profile </h2>
            </div>
            <div class = "workout_content" style="color:white; text-align:left;">
              <p style="opacity: 50%; font-size: 1rem;"> Age </p> {{ optional($profile)->age }}
            </div>

            <div class = "workout_content" style="color:white; text-align:left;">
              <p style="opacity: 50%; font-size: 1rem;"> Gender </p> {{ ucfirst(optional($profile)->gender) }}
            </div>

            <div class = "workout_content" style="color:white; text-align:left;" >
              <p style="opacity: 50%; font-size: 1rem;"> Current Weight </p> {{ optional($profile)->weight }} kg
            </div>
          </div>

          <div class="actions">
            <div class = "actions_3">
              <a onclick="document.getElementById('profileModal').classList.remove('hidden')"class="btn play"> 
                <button> Edit Profile </button>
              </a>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>    
  
  <!-- Modal Background -->
<div id="editModal" class="modal-overlay hidden">
  <!-- Modal Box -->
  <div class="modal-box">
    <div class="modal-header">
      <h2>Change Password</h2>
      <button onclick="document.getElementById('editModal').classList.add('hidden')" class="modal-close">&times;</button>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <!-- Change Password Form -->
    <form action="/change-password" method="POST">
      @csrf
      <div class="form-group">
        {{-- <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password" class="form-input" placeholder="Enter current password" required />
      </div> --}}
          <label for="current_password">Current Password</label>
          <input type="password" id="current_password" name="current_password" class="form-input" placeholder="Enter current password" required />
          @error('current_password')
              <div class="alert alert-danger" style="color: #dc3545; font-size: 0.9em;">
                  {{ $message }}
              </div>
          @enderror
      </div>

      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" class="form-input" placeholder="Enter new password" required />
      </div>

      <div class="form-group">
        <label for="new_password_confirmation">Confirm New Password</label>
        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input" placeholder="Confirm new password" required />
      </div>

      <div class="modal-actions">
        <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="btn btn-secondary">Cancel</button>
        <button type="submit" class="btn btn-primary">Change Password</button>
      </div>
    </form>
  </div>
</div>


<!-- Modal -->
<div id="profileModal" class="modal-overlay hidden">
  <div class="modal-box">
    <div class="modal-header">
      <h2>Edit Profile</h2>
      <button onclick="document.getElementById('profileModal').classList.add('hidden')" class="modal-close">&times;</button>
    </div>

    <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      <div class="form-group">
          <label for="profileName">Name</label>
          <input type="text" id="profileName" name="name" class="form-input" placeholder="Your name"
                value="{{ $user->Fname }} {{ $user->Lname }}" />
      </div>

      <div class="form-group">
          <label for="profileAge">Age</label>
          <input type="number" id="profileAge" name="age" class="form-input" placeholder="Your age"
                value="{{ $user->age }}" />
      </div>

      <div class="form-group">
          <label for="profileGender">Gender</label>
          <select id="profileGender" name="gender" class="form-input">
              <option value="">Select gender</option>
              <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
              <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
              <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
              <option value="Prefer not to say" {{ $user->gender == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
          </select>
      </div>

      <div class="form-group">
          <label for="profileWeight">Current Weight (kg)</label>
          <input type="number" id="profileWeight" name="weight" class="form-input" placeholder="e.g. 70"
            value="{{ $user->weight }}" min="20" max="300" step="0.01" />
      </div>

      <div class="modal-actions">
          <button type="button" onclick="document.getElementById('profileModal').classList.add('hidden')" class="btn btn-secondary">
              Cancel
          </button>
          <button type="submit" class="btn btn-primary">
              Save Changes
          </button>
      </div>
  </form>
  </div>
</div>

  </body>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        const loader = document.getElementById('loader-wrapper');
        loader.style.opacity = '0';
        setTimeout(() => loader.style.display = 'none', 500);
    }, 300); // Adjust delay if needed
});

function toggleSidebar() {
  const sidebar = document.querySelector('.sidebar');
  const closeBtn = document.querySelector('.close-btn');

  if (sidebar.style.left === '-250px') {
    sidebar.style.left = '0';
    closeBtn.style.display = 'block'; // Show close button when sidebar is visible
  } else {
    sidebar.style.left = '-250px';
    closeBtn.style.display = 'none'; // Hide close button when sidebar is hidden
  }
}
</script>
  </html>
