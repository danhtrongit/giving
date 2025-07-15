document.addEventListener('DOMContentLoaded', function() {
    // Get all member buttons and cards using common class prefixes
    const memberButtons = document.querySelectorAll('[class*="member-button-"]');
    const memberCards = document.querySelectorAll('[class*="member-card-"]');

    // Add click event to each button
    memberButtons.forEach((button) => {
        button.addEventListener('click', function() {
            // Get the button number from its class
            const buttonClass = Array.from(button.classList).find(cls => cls.match(/member-button-\d+/));
            const buttonNumber = buttonClass ? buttonClass.split('-').pop() : null;
            
            if (!buttonNumber) return;
            
            // Remove active class from all cards and buttons
            memberCards.forEach(card => card.classList.remove('active'));
            memberButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to the clicked button
            button.classList.add('active');
            
            // Find and activate the corresponding card
            const targetCard = document.querySelector(`.member-card-${buttonNumber}`);
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