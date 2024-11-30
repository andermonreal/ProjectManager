document.addEventListener('DOMContentLoaded', () => {
    const testimonials = [
        { "name": "John Doe", "role": "Project Lead", "quote": "Project Manager has transformed the way our team works together!" },
        { "name": "Jane Smith", "role": "Product Manager", "quote": "I can't imagine managing my projects without it!" },
        { "name": "Alice Johnson", "role": "Marketing Specialist", "quote": "This tool has made project tracking so easy and efficient!" },
        { "name": "Tom Richards", "role": "UX Designer", "quote": "The interface is intuitive and makes collaboration seamless." },
        { "name": "Emily White", "role": "HR Manager", "quote": "Managing tasks and deadlines has never been easier." },
        { "name": "David Brown", "role": "Software Developer", "quote": "With this tool, I stay on top of my code reviews and deployments." },
        { "name": "Sarah Lee", "role": "Quality Assurance", "quote": "It's so easy to report bugs and track progress with this platform." },
        { "name": "Michael Carter", "role": "Sales Executive", "quote": "Project Manager has helped me keep track of client deliverables and sales milestones." },
        { "name": "Sophia Martin", "role": "Operations Manager", "quote": "I love how streamlined the process is now, everything in one place!" },
        { "name": "James Miller", "role": "Business Analyst", "quote": "The insights provided by this tool have been a game-changer for project planning." },
        { "name": "Anna Clark", "role": "Customer Support Lead", "quote": "Being able to track customer issues and resolutions in real time is invaluable." },
        { "name": "Paul Wilson", "role": "Chief Technology Officer", "quote": "It has significantly improved team collaboration and product delivery timelines." },
        { "name": "Chloe King", "role": "Marketing Director", "quote": "Project Manager keeps us aligned and helps us hit every campaign deadline." },
        { "name": "William Moore", "role": "Finance Director", "quote": "Managing budgets and resource allocation is so much simpler now." },
        { "name": "Lily Green", "role": "Product Designer", "quote": "I can track every iteration of our designs and feedback easily in one place." },
        { "name": "Chris Young", "role": "IT Support", "quote": "This platform makes it easy to manage our tech infrastructure projects." },
        { "name": "Isabella Scott", "role": "Chief Operating Officer", "quote": "We’ve been able to reduce delays and bottlenecks, which has improved our bottom line." },
        { "name": "Nathan Adams", "role": "Project Coordinator", "quote": "The task assignment feature ensures that nothing slips through the cracks." },
        { "name": "Olivia Taylor", "role": "Product Owner", "quote": "This has become an essential tool for tracking our product development lifecycle." },
        { "name": "Ethan Harris", "role": "Operations Specialist", "quote": "From planning to execution, I’m able to keep my projects moving smoothly." },
        { "name": "Madison Martinez", "role": "Content Manager", "quote": "It’s easy to assign tasks, track deadlines, and communicate across teams." },
        { "name": "Lucas Allen", "role": "Data Scientist", "quote": "Having all my project data organized here makes analysis and reporting much more effective." },
        { "name": "Zoe Nelson", "role": "Account Manager", "quote": "This tool is fantastic for keeping track of client expectations and deadlines." },
        { "name": "Benjamin Perez", "role": "Senior Developer", "quote": "Collaboration is seamless, and task management is more organized than ever." },
        { "name": "Grace Edwards", "role": "HR Specialist", "quote": "It makes tracking employee progress and project assignments so much more transparent." },
        { "name": "Henry Wright", "role": "Chief Executive Officer", "quote": "Having a clear overview of projects and tasks has been instrumental in our company's growth." },
        { "name": "Jackie Walker", "role": "Client Services Manager", "quote": "I love how easy it is to manage multiple projects and keep everyone in the loop." },
        { "name": "George Hall", "role": "Business Development Manager", "quote": "I rely on this tool every day to track our growth projects and stay on top of opportunities." },
        { "name": "Megan Lee", "role": "Lead Developer", "quote": "This platform has helped us streamline our sprint planning and task management processes." },
        { "name": "Samuel Rodriguez", "role": "Project Analyst", "quote": "It’s so easy to create and track milestones, which makes my job much easier." },
        { "name": "Ava King", "role": "Customer Experience Manager", "quote": "This tool helps us ensure every project meets client expectations and deadlines." },
        { "name": "Ryan Scott", "role": "Marketing Assistant", "quote": "I can't believe how much time we've saved by using this project management tool." },
        { "name": "Charlotte Carter", "role": "Event Coordinator", "quote": "This tool keeps me organized and helps ensure every event runs smoothly." },
        { "name": "Jackson Green", "role": "Product Engineer", "quote": "Managing and tracking product timelines and updates has never been easier." },
        { "name": "Victoria Mitchell", "role": "Researcher", "quote": "It's easy to manage research projects and track progress with this tool." },
        { "name": "Eli Turner", "role": "Financial Analyst", "quote": "This project management platform has made budgeting for projects simple and effective." },
        { "name": "Liam Wright", "role": "Product Developer", "quote": "I use this tool daily to make sure our product development is on track." },
        { "name": "Chloe Anderson", "role": "Creative Director", "quote": "It’s the perfect tool for managing our creative team’s workflow and deadlines." },
        { "name": "Evan Collins", "role": "Operations Manager", "quote": "Project Manager helps streamline our operations and keep everything on schedule." },
        { "name": "Aria Roberts", "role": "Marketing Analyst", "quote": "It’s been amazing for tracking marketing campaigns and ensuring targets are met." },
        { "name": "Owen Morris", "role": "Quality Assurance Lead", "quote": "This tool has made it much easier to track and fix bugs across multiple projects." },
        { "name": "Ella Young", "role": "Product Support Specialist", "quote": "Being able to track product issues and resolutions is so convenient." },
        { "name": "Joshua Davis", "role": "IT Director", "quote": "Managing IT infrastructure projects has become so much easier and organized." }
    ];

    const testimonialContainer = document.createElement('div');
    testimonialContainer.className = 'testimonial-container';

    const showRandomTestimonial = () => {
        const randomIndex = Math.floor(Math.random() * testimonials.length);
        const testimonial = testimonials[randomIndex];

        testimonialContainer.innerHTML = `
            <blockquote>
                <p>"${testimonial.quote}"</p>
                <footer>- ${testimonial.name}, ${testimonial.role}</footer>
            </blockquote>
        `;
    };

    document.getElementById('testimonials').appendChild(testimonialContainer);
    showRandomTestimonial();

    // Change testimonial every 5 seconds
    setInterval(showRandomTestimonial, 5000);
});
