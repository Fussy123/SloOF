let body = document.getElementById('body')

button_web.addEventListener('click', function() {

    intro.classList.add('slide-out');
    setTimeout(function () {
        intro.classList.add("hidden")
    }, 400);
    // Переход на sevices по умолчанию.
    closeAllSectionsExcept(services);
    openSection(services);
    openfooterheader();
    body.style.backgroundImage = '';
    setTimeout(function() {
        moveDot(servicebtn);
    }, 900);
});

let menuServicebtn = document.getElementById('menuServicebtn')
let menuBlogbtn = document.getElementById('menuBlogbtn')
let menuSocialbtn = document.getElementById('menuSocialbtn')

let serviceButtonContact = document.getElementById('serviceButtonContact');

serviceButtonContact.addEventListener('click', function() {
    socialbtn.click();
});

menuServicebtn.addEventListener('click', function() {
    servicebtn.click();
});

servicebtn.addEventListener('click', function() {
    closeAllSectionsExcept(services);
    openSection(services);
    handleModalClose();
});

menuBlogbtn.addEventListener('click', function() {
    blogbtn.click();
});

blogbtn.addEventListener('click', function() {
    closeAllSectionsExcept(blog);
    openSection(blog);
    handleModalClose();
});

menuSocialbtn.addEventListener('click', function() {
    socialbtn.click();
});


socialbtn.addEventListener('click', function() {
    closeAllSectionsExcept(social);
    openSection(social);
    animationLogo2();
    handleModalOpen();
});


insanepagebtn.addEventListener('click', function() {
    closeAllSectionsExcept(intro);
    openSection(intro);
    closefooterheader();
    handleModalClose();
    body.style.backgroundImage = 'url(/images/Intro.png)';
});

function closeAllSectionsExcept(sectionToKeepOpen) {
    // Закрываем все разделы кроме указанного
    let sections = [services, blog, social, intro];
    sections.forEach(function(section) {
        if (section !== sectionToKeepOpen) {
            closeSection(section);
        }
    });
}

function openSection(section) {
    section.classList.remove('slide-out')
    section.classList.add('slide-in');
    setTimeout(function() {
        footer.style.right = section.style.right = "0px";
        section.classList.remove("hidden");
        section.classList.add("flex");
    }, 400);
}

function closeSection(section) {
    section.classList.remove('slide-in')
    section.classList.add('slide-out');
    setTimeout(function() {
        section.classList.add("hidden");
        section.classList.remove("flex");
    }, 400);
}

function closefooterheader(){
    footer.classList.remove('slide-in')
    header.classList.remove('slide-in')
    footer.classList.add('slide-out');
    header.classList.add('slide-out');
    setTimeout(function() {
        footer.classList.add("hidden");
        header.classList.add("hidden");
    }, 400);
}

function openfooterheader(){
    footer.classList.add('slide-in')
    header.classList.add('slide-in')
    footer.classList.remove('slide-out');
    header.classList.remove('slide-out');
    setTimeout(function() {
        footer.classList.remove("hidden");
        header.classList.remove("hidden");
    }, 400);
}