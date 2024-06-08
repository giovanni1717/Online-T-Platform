document.addEventListener("DOMContentLoaded", function() {
    // Get the referrer URL
    var referrer = document.referrer;

    // Find the anchor element by its ID
    var anchor = document.getElementById("indietro");

    // Check if there's a referrer and the anchor element exists
    if (referrer && anchor) {
        // Set the href attribute of the anchor to the referrer URL
        anchor.href = referrer;
    } else if (anchor) {
        // Optional: handle the case where there's no referrer
        anchor.removeAttribute("href");
    }
});