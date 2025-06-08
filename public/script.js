let selectedValues = {}; // Tracks selected value per input field

document.querySelectorAll(".goal-button").forEach(button => {
  button.addEventListener("click", () => {
    const field = button.closest("form").querySelector("input[type='hidden']");
    const fieldName = field.getAttribute("name");
    const label = button.getAttribute("data-goal");

    if (selectedValues[fieldName] === label) return;

    // Remove active class from previous
    if (selectedValues[fieldName]) {
      const prevButton = document.querySelector(`.goal-button[data-goal="${selectedValues[fieldName]}"]`);
      if (prevButton) prevButton.classList.remove("active");
    }

    // Set active
    button.classList.add("active");
    selectedValues[fieldName] = label;

    // Set hidden input value
    field.value = mapLabelToBackend(label);
  });
});



function mapLabelToBackend(label) {
  const map = {
    // Goal step
    "Lose Fat": "lose_fat",
    "Build Muscle": "gain_muscle",
    "Get Toned": "maintenance",

    // Intensity step
    "High Intensity": "high",
    "Moderate": "moderate",
    "Low Intensity": "low",

    // Setup step (if any)
    "Full Gym": "full_gym",
    "Home": "home",

    // Level step (if any)
    "Beginner": "beginner",
    "Intermediate": "intermediate",
    "Advanced": "advanced",
  };

  return map[label] || label.toLowerCase().replace(" ", "_"); // fallback
}

function openPrivacyModal(event) {
  event.preventDefault();
  document.getElementById('privacyModal').style.display = 'block';
}

function closePrivacyModal() {
  document.getElementById('privacyModal').style.display = 'none';
}

window.onclick = function(event) {
  if (event.target == document.getElementById('privacyModal')) {
    closePrivacyModal();
  }
}


    document.querySelectorAll('.faq-question').forEach(question => {
      question.addEventListener('click', () => {
          question.classList.toggle('active');
          const answer = question.nextElementSibling;
          answer.classList.toggle('show');
      });
  });
  



  document.addEventListener('DOMContentLoaded', function () {
    const beepSound = new Audio('https://www.soundjay.com/button/beep-07.wav'); // You can use your own .mp3 or .wav

      let time = 300; // default 5 minutes
      let originalTime = time;
      let interval = null;
      const timerDisplay = document.getElementById('timer');
      const circle = document.querySelector('.progress-ring__circle');
      const radius = circle.r.baseVal.value;
      const circumference = 2 * Math.PI * radius;

      circle.style.strokeDasharray = `${circumference}`;
      circle.style.strokeDashoffset = `${circumference}`;

    function setCircleProgress(timeLeft) {
    const offset = circumference - (timeLeft / originalTime) * circumference;
    circle.style.strokeDashoffset = offset;
}


      function updateDisplay() {
          const minutes = Math.floor(time / 60);
          const seconds = time % 60;
          timerDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
          setCircleProgress(time);
      }

      function startTimer() {
    if (interval) return; // avoid double interval
    interval = setInterval(() => {
        if (time <= 0) {
            clearInterval(interval);
            interval = null;
            beepSound.play().catch(e => console.log("Beep blocked by browser:", e));
            timerDisplay.textContent = "Time's up!";
            return;
        }
        time--;
        updateDisplay();
    }, 1000);
}

      function stopTimer() {
          clearInterval(interval);
          interval = null;
      }

      function resetTimer() {
          stopTimer();
          time = originalTime;
          updateDisplay();
      }

      function editTime() {
          const input = prompt("Enter new time in minutes:", time / 60);
          if (input && !isNaN(input)) {
              stopTimer();
              time = parseInt(input) * 60;
              originalTime = time;
              updateDisplay();
          }
      }

      function setTimer(minutes) {
        stopTimer();
        time = minutes * 60;
        originalTime = time;
        updateDisplay();
    }

      // Initial display
      updateDisplay();

      // Event listeners
      document.getElementById('startBtn').addEventListener('click', startTimer);
      document.getElementById('stopBtn').addEventListener('click', stopTimer);
      document.getElementById('resetBtn').addEventListener('click', resetTimer);
      document.getElementById('editBtn').addEventListener('click', editTime);
    
    // Add event listeners for the new buttons
    document.getElementById('oneMinBtn').addEventListener('click', () => setTimer(1));
    document.getElementById('twoMinBtn').addEventListener('click', () => setTimer(2));
    document.getElementById('threeMinBtn').addEventListener('click', () => setTimer(3));
  });





  // document.addEventListener('DOMContentLoaded', function () {
  //   var options = {
  //     chart: {
  //       height: 350,
  //       type: 'radialBar'
  //     },
  //     series: [65, 40, 80], // Example percentages
  //     labels: ['Calories Lost', 'Weight Lost', 'Workout Completion'],
  //     plotOptions: {
  //       radialBar: {
  //         dataLabels: {
  //           name: {
  //             fontSize: '16px',
  //           },
  //           value: {
  //             fontSize: '14px',
  //           },
  //           total: {
  //             show: true,
  //             label: 'Overall Progress',
  //             formatter: function () {
  //               // Optional: average of the values
  //               return Math.round((65 + 40 + 80) / 3) + "%";
  //             }
  //           }
  //         }
  //       }
  //     },
  //     colors: ['#8FB031', '#6B8E23', '#4682B4'] // customize as needed
  //   };

  //   var chart = new ApexCharts(document.querySelector("#radialChart"), options);
  //   chart.render();
  // });

 function togglePassword(event) {
  const passwordInput = document.getElementById("password");
  const eyeIcon = document.getElementById("eyeIcon1"); // Target the specific icon

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
  } else {
    passwordInput.type = "password";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
  }
}

function togglePassword2(event) {
  const confirmPasswordInput = document.getElementById("password_confirmation");
  const eyeIcon = document.getElementById("eyeIcon2"); // Target the specific icon

  if (confirmPasswordInput.type === "password") {
    confirmPasswordInput.type = "text";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
  } else {
    confirmPasswordInput.type = "password";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
  }
}

function confirmUpdate() {
        return confirm("Are you sure you want to update your workout preferences?");
    }