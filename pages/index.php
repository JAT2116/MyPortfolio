<?php require '../db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jeHIEL.Tech || Portfolio Website</title>
    <link rel="icon" type="image/png" href="../admin/logo.png">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" type="image/png" sizes="16x16" href="../admin/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../admin/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../admin/logo.png">

    <link rel="manifest" href="../site.webmanifest">
</head>
<body>
    <header>
        <div class="logo">je<span>HIEL</span>.Tech</div>
        <ul class="navlist">
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#service">Service</a></li>
            <li><a href="#skill">Skills</a></li>
            <li><a href="#portfolio">Portfolio</a></li>
            <li><a href="#contact">Contact Me</a></li>
        </ul>
        <div id="menu-icon" class='bx bx-menu'></div>
    </header>



    <section id="home" class="home">
        <div class="home-content">
            <h1>Hi! I'm Jehiel Tuan</h1>
            <div class="change-text">
                <h3>And I'm</h3>
                <h3>
                    <span class="word">Student</span>
                    <span class="word">Software&nbsp;Developer</span>
                    <span class="word">Web&nbsp;Designer</span>
                    <span class="word">Frontend&nbsp;and&nbsp;Backend&nbsp;Developer</span>
                </h3>
            </div>
            <?php
                $info_result = $conn->query("SELECT * FROM site_info");
                $site_info = [];
                if ($info_result) {
                    while($row = $info_result->fetch_assoc()){
                        $site_info[$row['info_key']] = $row['info_value'];
                    }
                }
            ?>
            <p>
                <?php echo htmlspecialchars($site_info['home_intro'] ?? 'Motivated computer science student and aspiring programmer with a solid foundation in software development and a passion for learning new technologies. Seeking an opportunity to contribute to real-world projects while gaining hands-on experience and growing as a developer.'); ?>
            </p>
            <div class="info-box">
                <div class="email-info">
                    <h5>Email:</h5>
                    <span><?php echo htmlspecialchars($site_info['email'] ?? 'your-email@example.com'); ?></span>
                </div>
                <div class="behance-info">
                    <h5>Facebook:</h5>
                    <span><?php echo htmlspecialchars($site_info['facebook'] ?? 'Your Facebook'); ?></span>
                </div>
            </div>
            <div class="btn-box">
                <a href="../file/MY_RESUME.pdf" class="btn" download>Download CV</a>
                <a href="../file/MY_RESUME.pdf" class="btn" target="_blank">Hire Me Now!</a>
            </div>
            <div class="social-icon">
                <a href="https://web.facebook.com/zetea.era.9" target="_blank"><i class='bx bxl-facebook-circle'></i></a>
                <a href="https://www.instagram.com/jehieltuan?igsh=bHk0NmsybGEyaDB5&utm_source=qr" target="_blank"><i class='bx bxl-instagram-alt' ></i></a>
            </div>
        </div>
        <div class="home-image">
            <div class="img-box">
                <img src="../admin/jehiel.png" alt="Jehiel Tuan profile picture">
            </div>
            <div class="liquid-shape">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" id="blobSvg">
                    <path fill="#12f7ff">
                        <animate attributeName="d"
                            dur="20000ms"
                            repeatCount="indefinite"
                            values="
                            M428,277Q416,304,398.5,324.5Q381,345,366,367Q351,389,333.5,421.5Q316,454,283,454Q250,454,217.5,452.5Q185,451,149,
                            444.5Q113,438,116,391.5Q119,345,106,323Q93,301,62.5,275.5Q32,250,47,219.5Q62,189,90.5,172Q119,155,113,104Q107,53,
                            142,39Q177,25,213.5,31Q250,37,273.5,72Q297,107,346,78.5Q395,50,396,96.5Q397,143,428,162.5Q459,182,449.5,216Q440,250,428,277Z;

                            M441.5,276Q410,302,414.5,337.5Q419,373,395.5,395.5Q372,418,349,451Q326,484,288,449.5Q250,415,220.5,423Q191,431,
                            176,402Q161,373,142,358Q123,343,110,321.5Q97,300,55.5,275Q14,250,17,212.5Q20,175,39,143Q58,111,88.5,90.5Q119,70,
                            160,84.5Q201,99,225.5,90.5Q250,82,284,62Q318,42,335.5,75Q353,108,377.5,123.5Q402,139,435.5,159Q469,179,471,214.5Q473,250,441.5,276Z;

                            M439,278Q422,306,403,326.5Q384,347,378,382.5Q372,418,334.5,406.5Q297,395,273.5,429Q250,463,219,452Q188,441,162.5,423Q137,
                            405,125,377.5Q113,350,99,327Q85,304,83.5,277Q82,250,64.5,217Q47,184,50,145.5Q53,107,99,106.5Q145,106,161,65Q177,24,213.5,
                            13Q250,2,275.5,48Q301,94,333.5,92Q366,90,397,105Q428,120,438,153Q448,186,452,218Q456,250,439,278Z;

                            M420.5,279Q429,308,429.5,344.5Q430,381,409.5,411Q389,441,353,448.5Q317,456,283.5,445Q250,434,212.5,
                            457.5Q175,481,156,443.5Q137,406,100.5,395.5Q64,385,42.5,355Q21,325,54.5,287.5Q88,250,94,225.5Q100,201,
                            84.5,160Q69,119,92,91.5Q115,64,155.5,74.5Q196,85,223,52.5Q250,20,276.5,53.5Q303,87,342.5,77.5Q382,68,384,
                            109.5Q386,151,394.5,175.5Q403,200,407.5,225Q412,250,420.5,279Z;

                            M449,280.5Q438,311,424,339Q410,367,383,381.5Q356,396,330.5,408Q305,420,277.5,435Q250,450,221,439.5Q192,429,166.5,414.5Q141,
                            400,107,389.5Q73,379,59.5,347.5Q46,316,33.5,283Q21,250,23.5,213.5Q26,177,56,154Q86,131,116,119Q146,107,161.5,66.5Q177,26,213.5,
                            26Q250,26,284,33.5Q318,41,331,81Q344,121,369,133Q394,145,432,161.5Q470,178,465,214Q460,250,449,280.5Z;

                            M411.5,275.5Q406,301,389.5,320Q373,339,374,380Q375,421,342.5,428.5Q310,436,280,421Q250,406,217.5,428.5Q185,451,165.5,422Q146,
                            393,132,369.5Q118,346,82.5,331Q47,316,56.5,283Q66,250,61.5,218.5Q57,187,88.5,171.5Q120,156,116.5,108.5Q113,61,153,68Q193,75,
                            221.5,55.5Q250,36,275,65.5Q300,95,341,82Q382,69,407,93.5Q432,118,431.5,154.5Q431,191,424,220.5Q417,250,411.5,275.5Z;

                            M462.5,283.5Q457,317,430,339Q403,361,393.5,398Q384,435,353,452.5Q322,470,286,470Q250,470,221,448.5Q192,427,155,429.5Q118,
                            432,114.5,391.5Q111,351,72.5,335.5Q34,320,19.5,285Q5,250,20.5,215.5Q36,181,44,143.5Q52,106,90.5,95Q129,84,160,75.5Q191,67,
                            220.5,34Q250,1,273.5,54Q297,107,340,87Q383,67,380.5,112Q378,157,430,166Q482,175,475,212.5Q468,250,462.5,283.5Z;

                            M428,277Q416,304,398.5,324.5Q381,345,366,367Q351,389,333.5,421.5Q316,454,283,454Q250,454,217.5,452.5Q185,451,149,
                            444.5Q113,438,116,391.5Q119,345,106,323Q93,301,62.5,275.5Q32,250,47,219.5Q62,189,90.5,172Q119,155,113,104Q107,53,
                            142,39Q177,25,213.5,31Q250,37,273.5,72Q297,107,346,78.5Q395,50,396,96.5Q397,143,428,162.5Q459,182,449.5,216Q440,250,428,277Z;
                            "
                        ></animate>
                    </path>
                </svg>
            </div>
            <div class="liquid-shape">
                <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="100%" id="blobSvg">
                    <path fill="#12f7ff">
                        <animate attributeName="d"
                            dur="20000ms"
                            repeatCount="indefinite"
                            values="
                            M428,277Q416,304,398.5,324.5Q381,345,366,367Q351,389,333.5,421.5Q316,454,283,454Q250,454,217.5,452.5Q185,451,149,
                            444.5Q113,438,116,391.5Q119,345,106,323Q93,301,62.5,275.5Q32,250,47,219.5Q62,189,90.5,172Q119,155,113,104Q107,53,
                            142,39Q177,25,213.5,31Q250,37,273.5,72Q297,107,346,78.5Q395,50,396,96.5Q397,143,428,162.5Q459,182,449.5,216Q440,250,428,277Z;

                            M441.5,276Q410,302,414.5,337.5Q419,373,395.5,395.5Q372,418,349,451Q326,484,288,449.5Q250,415,220.5,423Q191,431,
                            176,402Q161,373,142,358Q123,343,110,321.5Q97,300,55.5,275Q14,250,17,212.5Q20,175,39,143Q58,111,88.5,90.5Q119,70,
                            160,84.5Q201,99,225.5,90.5Q250,82,284,62Q318,42,335.5,75Q353,108,377.5,123.5Q402,139,435.5,159Q469,179,471,214.5Q473,250,441.5,276Z;

                            M439,278Q422,306,403,326.5Q384,347,378,382.5Q372,418,334.5,406.5Q297,395,273.5,429Q250,463,219,452Q188,441,162.5,423Q137,
                            405,125,377.5Q113,350,99,327Q85,304,83.5,277Q82,250,64.5,217Q47,184,50,145.5Q53,107,99,106.5Q145,106,161,65Q177,24,213.5,
                            13Q250,2,275.5,48Q301,94,333.5,92Q366,90,397,105Q428,120,438,153Q448,186,452,218Q456,250,439,278Z;

                            M420.5,279Q429,308,429.5,344.5Q430,381,409.5,411Q389,441,353,448.5Q317,456,283.5,445Q250,434,212.5,
                            457.5Q175,481,156,443.5Q137,406,100.5,395.5Q64,385,42.5,355Q21,325,54.5,287.5Q88,250,94,225.5Q100,201,
                            84.5,160Q69,119,92,91.5Q115,64,155.5,74.5Q196,85,223,52.5Q250,20,276.5,53.5Q303,87,342.5,77.5Q382,68,384,
                            109.5Q386,151,394.5,175.5Q403,200,407.5,225Q412,250,420.5,279Z;

                            M449,280.5Q438,311,424,339Q410,367,383,381.5Q356,396,330.5,408Q305,420,277.5,435Q250,450,221,439.5Q192,429,166.5,414.5Q141,
                            400,107,389.5Q73,379,59.5,347.5Q46,316,33.5,283Q21,250,23.5,213.5Q26,177,56,154Q86,131,116,119Q146,107,161.5,66.5Q177,26,213.5,
                            26Q250,26,284,33.5Q318,41,331,81Q344,121,369,133Q394,145,432,161.5Q470,178,465,214Q460,250,449,280.5Z;

                            M411.5,275.5Q406,301,389.5,320Q373,339,374,380Q375,421,342.5,428.5Q310,436,280,421Q250,406,217.5,428.5Q185,451,165.5,422Q146,
                            393,132,369.5Q118,346,82.5,331Q47,316,56.5,283Q66,250,61.5,218.5Q57,187,88.5,171.5Q120,156,116.5,108.5Q113,61,153,68Q193,75,
                            221.5,55.5Q250,36,275,65.5Q300,95,341,82Q382,69,407,93.5Q432,118,431.5,154.5Q431,191,424,220.5Q417,250,411.5,275.5Z;

                            M462.5,283.5Q457,317,430,339Q403,361,393.5,398Q384,435,353,452.5Q322,470,286,470Q250,470,221,448.5Q192,427,155,429.5Q118,
                            432,114.5,391.5Q111,351,72.5,335.5Q34,320,19.5,285Q5,250,20.5,215.5Q36,181,44,143.5Q52,106,90.5,95Q129,84,160,75.5Q191,67,
                            220.5,34Q250,1,273.5,54Q297,107,340,87Q383,67,380.5,112Q378,157,430,166Q482,175,475,212.5Q468,250,462.5,283.5Z;

                            M428,277Q416,304,398.5,324.5Q381,345,366,367Q351,389,333.5,421.5Q316,454,283,454Q250,454,217.5,452.5Q185,451,149,
                            444.5Q113,438,116,391.5Q119,345,106,323Q93,301,62.5,275.5Q32,250,47,219.5Q62,189,90.5,172Q119,155,113,104Q107,53,
                            142,39Q177,25,213.5,31Q250,37,273.5,72Q297,107,346,78.5Q395,50,396,96.5Q397,143,428,162.5Q459,182,449.5,216Q440,250,428,277Z;
                            "
                        ></animate>
                    </path>
                </svg>
            </div>
        </div>
    </section>


    <section id="about" class="about">
        <div class="img-about">
            <img src="../admin/m-3.png" alt="Decorative image for about section">
            
            <div class="info-about1">
                <span>2+</span>
                <p>Year of Experience</p>
            </div>
            <div class="info-about2">
                <span>5+</span>
                <p>Project Complete</p>
            </div>
            <div class="info-about3">
                <span>5+</span>
                <p>Programming Language</p>
            </div>
        </div>
        
        <div class="about-content">
            <span>Let me introduce myself</span>
            <h2>About me</h2>
            <h3>A story of good</h3>
            <p><?php echo htmlspecialchars($site_info['about_me'] ?? "I'm Jehiel Tuan, a student programmer and developer passionate about building real-world solutions through code. I’m constantly exploring new technologies and sharpening my skills to grow into a well-rounded software developer."); ?></p>

            <div class="btn-box">
                <a href="#" class="btn">Read More!</a>
            </div>
        </div>
    </section>


    <section id="service" class="service">
        <div class="main-text">
            <span>what i will do for you</span>
            <h2>Our services</h2>
        </div>

        <div class="section-services">
            <div class="service-box">
                <i class='bx bxs-layer service-icon'></i>
                <h3>Web Designer</h3>
                <p><?php echo htmlspecialchars($site_info['service_web_desc'] ?? 'As a web designer, I bring ideas to life through clean, creative, and user-focused designs that blend function with visual appeal.'); ?></p>
                <div class="btn-box service-btn">
                    <a href="#" class="btn">Read More!</a>
                </div>
            </div>

            <div class="service-box">
                <i class='bx bxs-graduation service-icon' ></i>
                <h3>Student</h3>
                <p><?php echo htmlspecialchars($site_info['service_student_desc'] ?? 'As a computer science student is a constant cycle of coding, debugging, caffeine, and the occasional existential crisis over semicolons.'); ?></p>
                <div class="btn-box service-btn">
                    <a href="#" class="btn">Read More!</a>
                </div>
            </div>

            <div class="service-box">
                <i class='bx bx-code-alt service-icon' ></i>
                <h3>Software Developer</h3>
                <p><?php echo htmlspecialchars($site_info['service_dev_desc'] ?? 'As a software developer is a blend of solving complex problems, writing and rewriting code, and endlessly learning to keep up with ever-evolving technology.'); ?></p>
                <div class="btn-box service-btn">
                    <a href="#" class="btn">Read More!</a>
                </div>
            </div>

            <div class="service-box">
                <i class='bx bxs-coin-stack service-icon' ></i>
                <h3>Frontend And Backend Developer</h3>
                <p><?php echo htmlspecialchars($site_info['service_fullstack_desc'] ?? 'As a frontend and backend developer means juggling user experience and server logic, turning ideas into seamless interfaces while ensuring everything runs smoothly behind the scenes.'); ?></p>
                <div class="btn-box service-btn">
                    <a href="#" class="btn">Read More!</a>
                </div>
            </div>
        </div>
    </section>


    <section id="skill" class="skill">
        <div class="main-text">
            <span>Technical and Professional</span>
            <h1>My Skills</h1>
        </div>

        <div class="skill-main">
            <div class="skill-left">
                <h3>Technical Skill</h3>
                <div class="skill-bar">
                    <div class="info">
                        <p>HTML</p>
                        <p>85%</p>
                    </div>
                    <div class="bar">
                        <span class="html"></span>
                    </div>
                </div>

                <div class="skill-bar">
                    <div class="info">
                        <p>CSS</p>
                        <p>90%</p>
                    </div>
                    <div class="bar">
                        <span class="css"></span>
                    </div>
                </div>

                <div class="skill-bar">
                    <div class="info">
                        <p>JavaScript</p>
                        <p>50%</p>
                    </div>
                    <div class="bar">
                        <span class="javascript"></span>
                    </div>
                </div>

                <div class="skill-bar">
                    <div class="info">
                        <p>Python</p>
                        <p>50%</p>
                    </div>
                    <div class="bar">
                        <span class="python"></span>
                    </div>
                </div>

                <div class="skill-bar">
                    <div class="info">
                        <p>VB.Net</p>
                        <p>75%</p>
                    </div>
                    <div class="bar">
                        <span class="vb-net"></span>
                    </div>
                </div>

                <div class="skill-bar">
                    <div class="info">
                        <p>C++/C#</p>
                        <p>50%</p>
                    </div>
                    <div class="bar">
                        <span class="cFamily"></span>
                    </div>
                </div>
            </div>
            <div class="skill-rigth">
                <h3>Professional Skill</h3>
                <div class="professional">
                    <div class="box">
                        <div class="circle" data-dots="50" data-percent="85"></div>
                        <div class="text">
                            <big>85%</big>
                            <small>Creativity</small>
                        </div>
                    </div>

                    <div class="box">
                        <div class="circle" data-dots="50" data-percent="95"></div>
                        <div class="text">
                            <big>95%</big>
                            <small>Team Work</small>
                        </div>
                    </div>

                    <div class="box">
                        <div class="circle" data-dots="50" data-percent="93"></div>
                        <div class="text">
                            <big>93%</big>
                            <small>Communication</small>
                        </div>
                    </div>

                    <div class="box">
                        <div class="circle" data-dots="50" data-percent="87"></div>
                        <div class="text">
                            <big>87%</big>
                            <small>Project Management</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="portfolio" class="portfolio">
        <div class="main-text">
            <span>What i will do for you?</span>
            <h1>Latest Project</h1>
        </div>

        <div class="container">
            <div class="filter-buttons">
                <button class="btn" data-filter="all">All</button>
                <button class="btn" data-filter=".web">Web App</button>
                <button class="btn" data-filter=".thesis">Thesis</button>
                <button class="btn" data-filter=".python">Python</button>
                <button class="btn" data-filter=".cpp_cs">C++/C#</button>
                <button class="btn" data-filter=".vbnet">VB.Net</button>
            </div>

            <div class="portfolio-gallery">
                <?php
                    $projects_result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
                    if ($projects_result) {
                        while($project = $projects_result->fetch_assoc()):
                ?>
                <div class="port-box mix <?php echo htmlspecialchars($project['category']); ?>">
                    <div class="port-image">
                        <?php
                            $file_path = $project['image_path'];
                            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                            $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                            $is_image = in_array($file_extension, $image_extensions);

                            if ($is_image) {
                        ?>
                            <img src="../<?php echo htmlspecialchars($project['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>">
                        <?php
                            } else {
                        ?>
                            <div class="doc-icon">
                                <i class='bx bxs-file-doc'></i>
                                <p><?php echo htmlspecialchars($project['category'] == 'thesis' ? 'Thesis Document' : 'Project Document'); ?></p>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="port-content">
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p>
                           <?php echo htmlspecialchars($project['description']); ?>
                        </p>
                        <?php if (!empty($project['document_path'])): ?>
                            <a href="../<?php echo htmlspecialchars($project['document_path']); ?>" target="_blank"><i class='bx bxs-download'></i></a>
                        <?php elseif ($is_image && !empty($project['project_link'])): ?>
                            <a href="<?php echo htmlspecialchars($project['project_link']); ?>" target="_blank"><i class='bx bx-link-external'></i></a>
                        <?php elseif (!$is_image): ?>
                            <a href="../<?php echo htmlspecialchars($project['image_path']); ?>" target="_blank" download><i class='bx bxs-download'></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php
                        endwhile;
                    } ?>
            </div>
        </div>
    </section>


    <section id="contact" class="contact">
        <div class="main-text">
            <span>ask me question</span>
            <h1>Contact Me</h1>
        </div>

        <form action="#">
            <input type="text" placeholder="Your Full Name">
            <input type="text" placeholder="Your Email">
            <input type="text" placeholder="Your Address">
            <input type="text" placeholder="Phone Number">
            <textarea name="" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
            <div class="btn-box formBtn">
                <button type="submit" class="btn">Send Message</button>
            </div>
        </form>
    </section>

    
    <script src="../mixitup.min.js"></script>

    <script src="../script.js?v=<?php echo time(); ?>"></script>    
</body>
</html>
<?php $conn->close(); ?>
