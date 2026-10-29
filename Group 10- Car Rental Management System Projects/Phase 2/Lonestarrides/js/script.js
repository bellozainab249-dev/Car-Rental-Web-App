document.addEventListener('DOMContentLoaded', function() {
    const checkbox = document.getElementById('sameLocation');
    const dropoffGroup = document.getElementById('dropoffGroup');

    // Make sure the elements actually exist on the page before running the code
    if (checkbox && dropoffGroup) {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                // Hide if checked
                dropoffGroup.style.display = 'none';
                dropoffGroup.querySelector('select').removeAttribute('required');
            } else {
                // Show if unchecked
                dropoffGroup.style.display = 'flex';
                dropoffGroup.style.flexDirection = 'column';
                dropoffGroup.querySelector('select').setAttribute('required', 'required');
            }
        });
    }
});