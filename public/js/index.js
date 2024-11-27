document.addEventListener('DOMContentLoaded', () => {
    const testimonials = [
        { name: "John Doe", role: "Project Lead", quote: "Project Manager has transformed the way our team works together!" },
        { name: "Jane Smith", role: "Product Manager", quote: "I can't imagine managing my projects without it!" },
        { name: "Alice Johnson", role: "Marketing Specialist", quote: "This tool has made project tracking so easy and efficient!" }
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

    document.querySelector('section').appendChild(testimonialContainer);
    showRandomTestimonial();

    // Change testimonial every 5 seconds
    setInterval(showRandomTestimonial, 5000);
});
