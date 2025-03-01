    <style>
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            padding: 2rem;
            margin-bottom: 10px;
        }
        .bento-item {
            background-color: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease-in-out;
        }
        .big { grid-column: span 2; grid-row: span 2; }
        .medium { grid-column: span 2; }
        .small { grid-column: span 1; }
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        @media (max-width: 992px) {
            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 768px) {
            .bento-grid {
                grid-template-columns: repeat(1, 1fr);
            }
        }
        @media (max-width: 667px) {
            .bento-grid {
                grid-template-columns: repeat(1, 1fr);
            }
            .big { grid-column: span 2; grid-row: span 2; }
            .medium { grid-column: span 2; }
            .small { grid-column: span 2; }
            .profile-img {
                width: 100px;
                height: 100px;
                border-radius: 50%;
            }
        }
    </style>
    <div class="container">
        <h1 class="text-center my-4">My Portfolio</h1>
        <div class="bento-grid">

            <!-- Profile -->
            <div class="bento-item big text-center">
                <img src="https://via.placeholder.com/100" class="profile-img" alt="Profile">
                <h2 class="mt-3">Your Name</h2>
                <p>Web Developer | PHP | Laravel | JavaScript</p>
            </div>

            <!-- Projects -->
            <div class="bento-item medium">
                <h3>Projects</h3>
                <ul>
                    <li>✅ <strong>Portfolio Website</strong> - Built with Laravel</li>
                    <li>✅ <strong>E-commerce Shop</strong> - PHP + MySQL</li>
                    <li>✅ <strong>Task Management App</strong> - Vue.js</li>
                </ul>
            </div>

            <!-- Skills -->
            <div class="bento-item small">
                <h3>Skills</h3>
                <p>✔ PHP, Laravel, MySQL, JavaScript, Vue.js, CSS, Bootstrap</p>
            </div>

            <!-- Contact -->
            <div class="bento-item small text-center">
                <h3>Contact</h3>
                <p>📧 your.email@example.com</p>
                <p>📍 Location: Philippines</p>
            </div>

            <!-- About -->
            <div class="bento-item medium">
                <h3>About Me</h3>
                <p>Passionate about web development, I build dynamic and responsive web applications. Always eager to learn and contribute to exciting projects.</p>
            </div>

            <!-- Blog or Testimonials -->
            <div class="bento-item small">
                <h3>Blog</h3>
                <p>🚀 Sharing insights on coding, frameworks, and best practices.</p>
            </div>

        </div>
    </div>
