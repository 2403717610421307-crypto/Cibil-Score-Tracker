// Simulate fetching CIBIL score with backend
function fetchCibilScore() {
    fetch('../../api/fetch_score.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({user_id: '<?php echo $_SESSION["id"]; ?>'}) // Assume session id available, but in JS, need to pass or use cookie
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('score').innerText = data.score;
        console.log(`Fetched CIBIL Score: ${data.score}`);
        // Reload history
        location.reload(); // Simple reload to update history table
    })
    .catch(error => console.error('Error:', error));
}

// Other functions remain similar, but update to use fetch if needed
function updateProfile() {
    // Form submit handles in PHP
}

function setCreditGoal() {
    // Form submit handles in PHP
}

function generateRecommendations() {
    const recommendations = [
        'Pay off high-interest debts first.',
        'Keep credit utilization below 30%.',
        'Set up payment reminders to avoid late payments.'
    ];
    const randomRec = recommendations[Math.floor(Math.random() * recommendations.length)];
    document.getElementById('recs').innerText = randomRec;
    console.log(`Recommendation generated: ${randomRec}`);
}

// Update score history (reload page after add)
function updateScoreHistory() {
    fetchCibilScore(); // Calls fetch which adds to DB
}

// Admin functions
function manageApi() {
    alert('Credit Score Data API updated!');
    console.log('API management triggered');
}

function updateTip() {
    // Form submit handles in PHP
}

function editUser(email) {
    alert(`Editing user: ${email}`);
    console.log(`Edit action triggered for user: ${email}`);
}

function deleteUser(email) {
    alert(`User deleted: ${email}`);
    console.log(`Delete action triggered for user: ${email}`);
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', () => {
    const fetchScoreBtn = document.querySelector('#fetchScoreBtn');
    if (fetchScoreBtn) fetchScoreBtn.addEventListener('click', fetchCibilScore);

    // Other listeners removed if handled by PHP forms

    const recBtn = document.querySelector('#recBtn');
    if (recBtn) recBtn.addEventListener('click', generateRecommendations);

    const historyBtn = document.querySelector('#historyBtn');
    if (historyBtn) historyBtn.addEventListener('click', updateScoreHistory);

    const apiBtn = document.querySelector('#apiBtn');
    if (apiBtn) apiBtn.addEventListener('click', manageApi);

    const userActions = document.querySelectorAll('.user-action');
    userActions.forEach(btn => {
        btn.addEventListener('click', () => {
            const email = btn.dataset.email;
            if (btn.classList.contains('edit')) editUser(email);
            if (btn.classList.contains('delete')) deleteUser(email);
        });
    });
});