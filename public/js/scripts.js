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
});
/*blog tablosundaki user ıd yi kullanarak user name çek*/
document.addEventListener("DOMContentLoaded", function () {
    let offset = 4; // Atlanacak veri sayısı
    const limit = 4; // Veri Limiti
    let loadMoreBtn = document.getElementById("loadMoreBtn");

    function fetchBlogs(offset) {
        fetch(`/blogs/load-more-blogs?offset=${offset}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Veri çekme hatası!");
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // JSON formatında gelen veriyi kontrol et
                let blogs = data; // `blogs` anahtarına eriş

                if (!Array.isArray(blogs)) {
                    alert("Hata: Beklenen veri bir dizi değil.");
                    return;
                }
                handleBlogs(blogs);
            })
            .catch(error => console.error("Hata:", error));
    }

    function handleBlogs(blogs) {
        if (blogs.length === 0) {
            loadMoreBtn.style.display = "none";
            return;
        }

        let container = document.getElementById("blog-container");

        blogs.forEach(blog => {
            let blogDiv = document.createElement("div");
            blogDiv.classList.add("post-preview");
            blogDiv.innerHTML = `
                <a href="/blog-content/${blog.id}">
                <h2 class="post-title">${blog.title}</h2>
                <h3 class="post-subtitle">${blog.subTitle}</h3>
                </a>
                <p class="post-meta">
                    <a href="#">${blog.user.name} ${blog.user.surname}</a>
                    tarafından ${new Date(blog.created_at).toLocaleDateString('tr-TR',{ 
                        day: 'numeric', 
                        month: 'long',
                        year: 'numeric'
                    })} tarihinde paylaşıldı.
                </p>
                
                <hr class="my-4">
            `;
            container.appendChild(blogDiv);
        });

        offset += limit; // Sonraki tıklamada daha fazla veri getir
    }

    loadMoreBtn.addEventListener("click", function () {
        fetchBlogs(offset);
    });
});

