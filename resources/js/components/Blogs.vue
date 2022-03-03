<template>
    <div class="container">
        <h1>I nostri post</h1>

        <div class="row row-cols-3">
                <!-- Single post card -->
            <div v-for="blog in blogs" :key="blog.id" class="col">
                <div class="card my-2">
                    <!-- <img src="..." class="card-img-top" alt="..."> -->
                    <div class="card-body">
                        <h5 class="card-title">{{ blog.title }}</h5>
                        <p class="card-text">{{ truncateText(blog.content, 50) }}</p>
                    </div>
                    <!-- <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                    </ul> -->
                    <div class="card-body">
                        <a href="#" class="card-link">Card link</a>
                    </div>
                </div>
            </div>
            <!-- End Single post card -->
        </div>
        <nav>
                <ul class="pagination">
                    <!-- Previous link -->
                    <li class="page-item" :class="{ 'disabled': currentPage == 1 }">
                        <a @click="getBlogs(currentPage - 1)" class="page-link" href="#">Previous</a>
                    </li>

                    <!-- Pages link -->
                    <li v-for="n in lastPage" :key="n" class="page-item" :class="{ 'active': currentPage == n }">
                        <a @click="getBlogs(n)" class="page-link" href="#">{{ n }}</a>
                    </li>

                    <!-- Next link -->
                    <li class="page-item" :class="{ 'disabled': currentPage == lastPage }">
                        <a @click="getBlogs(currentPage + 1)" class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
    </div>
</template>

<script>
export default {
    name: 'Blogs',
    data: function() {
        return {
            blogs: [],
            currentPage: 1,
            lastPage: false
        };
    },
    methods: {
        getBlogs: function(pageNumber) {
            // Faremo la chiamata API per prenderci i post
            axios.get('/api/posts', { 
                params: {
                    page: pageNumber
                }
            })
            .then((response)=> {
                
                this.blogs = response.data.result.data;
                this.currentPage = response.data.result.current_page;
                this.lastPage = response.data.result.last_page;
                console.log(response);
            });
        },
        truncateText: function(text, maxCharsNumber) {
            
            if(text.length > maxCharsNumber) {
                return text.substr(0, maxCharsNumber) + '...';
            }
            return text;
        }
    },
    created: function() {
        this.getBlogs(1);
        
    }
}
</script>