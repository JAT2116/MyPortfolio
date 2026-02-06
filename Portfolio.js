import React, { useState, useEffect } from 'react';

// This would be your main Portfolio component
const Portfolio = () => {
    const [projects, setProjects] = useState([]);
    const [filteredProjects, setFilteredProjects] = useState([]);
    const [activeFilter, setActiveFilter] = useState('all');

    // 1. Fetch data from the API when the component mounts
    useEffect(() => {
        fetch('/api/projects.php')
            .then(response => response.json())
            .then(data => {
                setProjects(data);
                setFilteredProjects(data);
            })
            .catch(error => console.error('Error fetching projects:', error));
    }, []);

    // 2. Handle filter logic
    const handleFilter = (category) => {
        setActiveFilter(category);
        if (category === 'all') {
            setFilteredProjects(projects);
        } else {
            const filtered = projects.filter(p => p.category === category);
            setFilteredProjects(filtered);
        }
    };

    return (
        <section id="portfolio" className="porfolio">
            <div className="main-text">
                <span>What I will do for you?</span>
                <h1>Latest Project</h1>
            </div>

            <div className="container">
                {/* 3. Filter buttons that call the handler */}
                <div className="filter-buttons">
                    <button className={`btn ${activeFilter === 'all' ? 'active' : ''}`} onClick={() => handleFilter('all')}>All</button>
                    <button className={`btn ${activeFilter === 'product' ? 'active' : ''}`} onClick={() => handleFilter('product')}>Product</button>
                    <button className={`btn ${activeFilter === 'inter' ? 'active' : ''}`} onClick={() => handleFilter('inter')}>Interacting</button>
                    <button className={`btn ${activeFilter === 'web' ? 'active' : ''}`} onClick={() => handleFilter('web')}>Web App</button>
                </div>

                {/* 4. Render the filtered projects from state */}
                <div className="portfolio-gallery">
                    {filteredProjects.map(project => (
                        <div key={project.id} className={`port-box mix ${project.category}`}>
                            <div className="port-image">
                                <img src={project.image_path} alt={project.title} />
                            </div>
                            <div className="port-content">
                                <h3>{project.title}</h3>
                                <p>{project.description}</p>
                                <a href={project.project_link} target="_blank" rel="noopener noreferrer"><i className='bx bx-link-external'></i></a>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Portfolio;