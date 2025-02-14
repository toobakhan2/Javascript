document.addEventListener("DOMContentLoaded", () => {
    const allStar = document.querySelectorAll('.rating .star');
    const form = document.getElementById('review_form');
    const ratingValue = document.querySelector('.rating input');
    const popup = document.getElementById('success_popup');
    const closeBtn = popup.querySelector(".close");
    const leftGif = document.querySelector('.response_images img');

    // Define smiley link gifs for ratings
    const smileyImages = {
        1: 'img/1starcat.gif', // Very sad face
        2: 'img/2starcat.gif', // Neutral face
        3: 'img/3starcat.gif', // Slightly happy face
        4: 'img/4starcat.gif', // Happy face
        5: 'img/5starcat.gif', // Excited face
    };

    console.log("check len out of for each", allStar.length);
    // Handle star selection
    allStar.forEach((item, idx) => {
        item.addEventListener('click', function () {
            ratingValue.value = idx + 1; 
    
            // Clear the error message for the rating
            const ratingError = document.querySelector('.rating').nextElementSibling;
            if (ratingError) {
                ratingError.textContent = ''; // Clear error message
            }
    
            // Update star
            allStar.forEach((i) => {
                i.classList.replace('bxs-star', 'bx-star');
                i.classList.remove('active');
            });
    
            for (let i = 0; i <= idx; i++) {
                allStar[i].classList.replace('bx-star', 'bxs-star');
                allStar[i].classList.add('active');
            }
            // changing the gif image on the left side
            leftGif.src = smileyImages[idx + 1]; 
        });
    });
    

    // Handle input focus and validation styling
    document.querySelectorAll('.val_input input').forEach(input => {
        input.addEventListener('input', () => {
            const parent = input.parentElement;
            if (input.value.trim() !== '') {
                parent.classList.add('focused');
            } else {
                parent.classList.remove('focused');
            }
        });

        input.addEventListener('focus', () => {
            input.parentElement.classList.add('focused');
        });

        input.addEventListener('blur', () => {
            if (input.value.trim() === '') {
                input.parentElement.classList.remove('focused');
            }
        });
    });

    // Form validation
    
    function validateForm() {
        let isValid = true;
        const inputs = document.querySelectorAll('.val_input input');
        inputs.forEach(input => {
            const parent = input.parentElement;
            const errorMessage = parent.querySelector('.error-message');

            if (!input.value.trim()) {
                errorMessage.textContent = `${input.name} is required.`;
                isValid = false;
            } else if (input.type === 'email' && !validateEmail(input.value)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                isValid = false;
            } else {
                errorMessage.textContent = '';
            }
        });

        console.log('Rating value:', ratingValue.value);    
        if (!ratingValue.value) {
            const ratingError = document.querySelector('.rating').nextElementSibling;
            if (ratingError) ratingError.textContent = 'Please select a star rating.';
            isValid = false;
        }

        return isValid;
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // Prevent default form submission

        if (validateForm()) {
            const formData = new FormData(form);

            try {
                const response = await fetch(' http://localhost/Bartlett/index.php', {
                    method: 'POST',
                    body: formData,
                });
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    const rating = parseInt(ratingValue.value);
                    console.log('Smiley image set to:', smileyImages[rating]);
                    
                    // Update modal content dynamically
                    popup.querySelector('.name_box').textContent = result.name || 'Guest';
                    popup.querySelector('.popup_img').src = smileyImages[rating] || 'img/sad.png';
                
                    // Reset star ratings
                    allStar.forEach(star => {
                        star.classList.replace('bxs-star', 'bx-star');
                        star.classList.remove('active');
                    });
                    ratingValue.value = ''; // Reset the rating value
                
                    // Show the modal
                    popup.classList.add("show");
                    form.reset();
                    leftGif.src = 'img/curiouscat.gif'; 
                
                } else {
                    alert('Failed to submit the review. Please try again.');
                }
            } catch (error) {
                console.error('Error submitting the review:', error);
                alert('An error occurred while submitting your review.');
            }
        } else {
            console.log('An error occurred while submitting your review.');
            alert('An error occurred while submitting your review.');
        }
      
    });

    // Close modal logic
    closeBtn.addEventListener("click", () => {
        popup.classList.remove("show");
    });

    popup.addEventListener("click", (event) => {
        if (event.target === popup) {
            popup.classList.remove("show");
        }
    });
});
