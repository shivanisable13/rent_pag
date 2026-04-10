// ✅ UI LOADED
console.log("UI Loaded");

/* =========================
   PROFILE DROPDOWN
========================= */
function toggleMenu(){
    let menu = document.getElementById("dropdown");

    if(menu){
        menu.style.display = (menu.style.display === "block") ? "none" : "block";
    }
}

// 🔥 CLOSE DROPDOWN WHEN CLICK OUTSIDE
window.addEventListener("click", function(e){
    let menu = document.getElementById("dropdown");
    let avatar = document.querySelector(".avatar");

    if(menu && avatar){
        if(!avatar.contains(e.target) && !menu.contains(e.target)){
            menu.style.display = "none";
        }
    }
});


/* =========================
   PARTICLES BACKGROUND
========================= */



/* =========================
   IMAGE SLIDER (PROPERTY PAGE)
========================= */
function changeImage(el){
    let main = document.getElementById("mainImage");

    if(main && el){
        main.src = el.src;
    }
}


/* =========================
   SCROLL ANIMATION (FADE IN)
========================= */
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting){
            entry.target.style.opacity = 1;
            entry.target.style.transform = "translateY(0)";
        }
    });
});

function applyScrollAnimation(){
    const elements = document.querySelectorAll(".glass");

    elements.forEach(el => {
        el.style.opacity = 0;
        el.style.transform = "translateY(30px)";
        el.style.transition = "0.6s ease";

        observer.observe(el);
    });
}


/* =========================
   PASSWORD TOGGLE (👁️)
========================= */
function togglePassword(){
    let pass = document.getElementById("password");

    if(pass){
        if(pass.type === "password"){
            pass.type = "text";
        } else {
            pass.type = "password";
        }
    }
}


/* =========================
   BUTTON RIPPLE EFFECT 🔥
========================= */
function addRippleEffect(){
    const buttons = document.querySelectorAll("button");

    buttons.forEach(btn => {
        btn.addEventListener("click", function(e){
            let circle = document.createElement("span");
            circle.classList.add("ripple");

            let rect = btn.getBoundingClientRect();

            circle.style.left = (e.clientX - rect.left) + "px";
            circle.style.top = (e.clientY - rect.top) + "px";

            btn.appendChild(circle);

            setTimeout(() => {
                circle.remove();
            }, 500);
        });
    });
}


/* =========================
   INIT
========================= */
window.onload = function(){
    createParticles();
    applyScrollAnimation();
    addRippleEffect();
};
function togglePassword(){
    let pass = document.getElementById("password");

    if(pass.type === "password"){
        pass.type = "text";
    } else {
        pass.type = "password";
    }
}

