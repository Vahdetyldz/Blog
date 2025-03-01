/*!
* Start Bootstrap - Clean Blog v6.0.9 (https://startbootstrap.com/theme/clean-blog)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
*/
window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0;
    const mainNav = document.getElementById('mainNav');
    const headerHeight = mainNav.clientHeight;
    window.addEventListener('scroll', function() {
        const currentTop = document.body.getBoundingClientRect().top * -1;
        if ( currentTop < scrollPos) {
            // Scrolling Up
            if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-visible');
            } else {
                console.log(123);
                mainNav.classList.remove('is-visible', 'is-fixed');
            }
        } else {
            // Scrolling Down
            mainNav.classList.remove(['is-visible']);
            if (currentTop > headerHeight && !mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-fixed');
            }
        }
        scrollPos = currentTop;
    });
})
document.addEventListener("DOMContentLoaded", function () {
    let offset = 4; // İlk 4 blog yüklendi, şimdi 4'ten başlayacağız.
    document.getElementById("loadMore").addEventListener("click", function () {
        fetch(`/load-more-blogs?offset=${offset}`)
            .then(response => response.json())
            .then(data => {
                if (data.blogs.length > 0) {
                    let container = document.getElementById("blog-container");
                    data.blogs.forEach(blog => {
                        let postHTML = `
                            <div class="post-preview">
                                <a href="#"><h2 class="post-title">${blog.title}</h2></a>
                                <p class="post-meta">
                                    <a href="#!">${blog.user.name} ${blog.user.surname}</a> 
                                    Tarafından 
                                    <a href="#!">${blog.date}</a> 
                                    Tarihinde Paylaşıldı
                                </p>
                            </div>
                            <hr class="my-4" />
                        `;
                        container.insertAdjacentHTML("beforeend", postHTML);
                    });

                    offset += 4; // Bir sonraki yüklemede 4 artır.
                } else {
                    document.getElementById("loadMore").style.display = "none"; // Veri bittiğinde butonu kaldır.
                }
            });
    });
});
