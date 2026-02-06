const loginForm = document.getElementById('login-form');
const loginPage = document.getElementById('login-page');
const dashboard = document.getElementById('dashboard');

// Simple login validation (demo only)
loginForm.addEventListener('submit', (e) => {
    e.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username === 'admin' && password === 'password') {
        loginPage.classList.add('hidden');
        dashboard.classList.remove('hidden');
        localStorage.setItem('adminLogged', 'true');
        loadAdminData();
    } else {
        alert('Invalid credentials');
    }
});

// Check if already logged in
window.addEventListener('load', () => {
    if (localStorage.getItem('adminLogged') === 'true') {
        loginPage.classList.add('hidden');
        dashboard.classList.remove('hidden');
        loadAdminData();
    }
});

// Logout function
function logout() {
    localStorage.removeItem('adminLogged');
    localStorage.removeItem('adminProjects');
    localStorage.removeItem('adminMessages');
    loginPage.classList.remove('hidden');
    dashboard.classList.add('hidden');
    document.getElementById('login-form').reset();
}

// Show section
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(el => el.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    
    document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
    event.target.classList.add('active');
}

// Load admin data
function loadAdminData() {
    loadProjects();
    loadMessages();
    loadAboutData();
    loadSettings();
}

// Projects Management
let projects = JSON.parse(localStorage.getItem('adminProjects')) || [
    { id: 1, title: 'Project 1', desc: 'Description of your first project', link: '#' },
    { id: 2, title: 'Project 2', desc: 'Description of your second project', link: '#' },
    { id: 3, title: 'Project 3', desc: 'Description of your third project', link: '#' }
];

function loadProjects() {
    renderProjectsList();
}

function renderProjectsList() {
    const list = document.getElementById('projects-list');
    if (projects.length === 0) {
        list.innerHTML = '<div class="empty-state"><p>No projects yet. Add one to get started!</p></div>';
        return;
    }

    list.innerHTML = projects.map(project => `
        <div class="project-item">
            <img src="assets/images/project${project.id}.jpg" alt="${project.title}" onerror="this.src='https://via.placeholder.com/300x200'">
            <div class="project-info">
                <h3>${project.title}</h3>
                <p>${project.desc}</p>
                <div class="project-actions">
                    <button class="btn btn-primary btn-small" onclick="editProject(${project.id})">Edit</button>
                    <button class="btn btn-delete" onclick="deleteProject(${project.id})">Delete</button>
                </div>
            </div>
        </div>
    `).join('');
}

function openProjectForm() {
    document.getElementById('project-form').classList.remove('hidden');
}

function closeProjectForm() {
    document.getElementById('project-form').classList.add('hidden');
    document.getElementById('project-input').reset();
}

document.getElementById('project-input').addEventListener('submit', (e) => {
    e.preventDefault();
    const title = document.getElementById('project-title').value;
    const desc = document.getElementById('project-desc').value;
    const link = document.getElementById('project-link').value;

    projects.push({
        id: projects.length + 1,
        title,
        desc,
        link
    });

    localStorage.setItem('adminProjects', JSON.stringify(projects));
    renderProjectsList();
    closeProjectForm();
    alert('Project added successfully!');
});

function deleteProject(id) {
    if (confirm('Are you sure you want to delete this project?')) {
        projects = projects.filter(p => p.id !== id);
        localStorage.setItem('adminProjects', JSON.stringify(projects));
        renderProjectsList();
    }
}

function editProject(id) {
    alert('Edit feature coming soon!');
}

// Messages Management
let messages = JSON.parse(localStorage.getItem('adminMessages')) || [];

function loadMessages() {
    updateMessageCount();
    renderMessagesList();
}

function renderMessagesList() {
    const list = document.getElementById('messages-list');
    if (messages.length === 0) {
        list.innerHTML = '<div class="empty-state"><p>No messages yet.</p></div>';
        return;
    }

    list.innerHTML = messages.map((msg, idx) => `
        <div class="message-item">
            <h4>${msg.name}</h4>
            <p class="message-email">${msg.email}</p>
            <p>${msg.message}</p>
            <button class="btn btn-delete message-delete" onclick="deleteMessage(${idx})">Delete</button>
        </div>
    `).join('');
}

function deleteMessage(idx) {
    messages.splice(idx, 1);
    localStorage.setItem('adminMessages', JSON.stringify(messages));
    renderMessagesList();
    updateMessageCount();
}

function updateMessageCount() {
    document.getElementById('message-count').textContent = messages.length;
}

// About Management
document.getElementById('about-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const aboutText = document.getElementById('about-text').value;
    const skills = document.getElementById('skills').value;
    localStorage.setItem('aboutData', JSON.stringify({ aboutText, skills }));
    alert('About section updated!');
});

function loadAboutData() {
    const data = JSON.parse(localStorage.getItem('aboutData')) || {};
    document.getElementById('about-text').value = data.aboutText || '';
    document.getElementById('skills').value = data.skills || '';
}

// Settings Management
document.getElementById('settings-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const settings = {
        siteTitle: document.getElementById('site-title').value,
        resumeLink: document.getElementById('resume-link').value,
        linkedin: document.getElementById('linkedin').value,
        github: document.getElementById('github').value,
        twitter: document.getElementById('twitter').value
    };
    localStorage.setItem('siteSettings', JSON.stringify(settings));
    alert('Settings saved!');
});

function loadSettings() {
    const settings = JSON.parse(localStorage.getItem('siteSettings')) || {};
    document.getElementById('site-title').value = settings.siteTitle || '';
    document.getElementById('resume-link').value = settings.resumeLink || '';
    document.getElementById('linkedin').value = settings.linkedin || '';
    document.getElementById('github').value = settings.github || '';
    document.getElementById('twitter').value = settings.twitter || '';
}

// Link main portfolio form to admin
if (typeof window !== 'undefined') {
    // Intercept portfolio contact form to save to admin
    const mainContactForm = document.querySelector('.contact-form');
    if (mainContactForm) {
        mainContactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const msg = {
                name: document.querySelector('input[placeholder="Your Name"]').value,
                email: document.querySelector('input[placeholder="Your Email"]').value,
                message: document.querySelector('textarea').value,
                date: new Date().toLocaleDateString()
            };
            messages.push(msg);
            localStorage.setItem('adminMessages', JSON.stringify(messages));
        });
    }
}
