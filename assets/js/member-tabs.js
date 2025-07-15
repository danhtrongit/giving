document.addEventListener('DOMContentLoaded', function() {
    // Get all member buttons and cards
    const memberButtons = document.querySelectorAll('.member-button-1, .member-button-2, .member-button-3');
    const memberCards = document.querySelectorAll('.member-card-1, .member-card-2, .member-card-3');

    // Add click event to each button
    memberButtons.forEach((button, index) => {
        button.addEventListener('click', function() {
            // Remove active class from all cards and buttons
            memberCards.forEach(card => card.classList.remove('active'));
            memberButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to the clicked button and corresponding card
            button.classList.add('active');
            
            // The index+1 corresponds to the card number (member-card-1, member-card-2, etc.)
            const cardNumber = index + 1;
            const targetCard = document.querySelector(`.member-card-${cardNumber}`);
            if (targetCard) {
                targetCard.classList.add('active');
            }
        });
    });

    // Initialize: Ensure the first card and button are active on page load
    if (memberButtons.length > 0 && memberCards.length > 0) {
        memberButtons[0].classList.add('active');
        memberCards[0].classList.add('active');
    }
}); 