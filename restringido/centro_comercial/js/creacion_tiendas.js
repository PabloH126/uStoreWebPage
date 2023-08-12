
document.addEventListener('DOMContentLoaded', function() {
    var checkboxes = document.querySelectorAll('#checkbox-list input[type="checkbox"]');
    var maxSelect = 8;

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var counter = document.querySelectorAll('#checkbox-list input[type="checkbox"]:checked').length;

            if(counter >= maxSelect)
            { 
                checkboxes.forEach(function(c) {
                    if(!c.checked)
                    {
                        c.disabled = true;
                    }
                });
            }
            else
            {
                checkboxes.forEach(function(c) {
                    c.disabled = false;
                });
            }
        });
    });
});