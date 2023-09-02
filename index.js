// JavaScript to show the bottom bar when scrolling down
// JavaScript to expand the bottom bar when scrolling down
window.addEventListener("scroll", function () {
    const aboutBar = document.getElementById("about-bar");
    if (window.scrollY > 100) { // Adjust the scroll position where the bar expands
        aboutBar.style.height = "60px"; // Adjust the expanded height as needed
    } else {
        aboutBar.style.height = "40px"; // Restore the initial height when scrolling up
    }
});