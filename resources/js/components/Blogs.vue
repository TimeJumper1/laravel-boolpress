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
                        <p class="card-text">{{ blog.content }}</p>
                    </div>
                    <!-- <ul class="list-group list-group-flush">
                        <li class="list-group-item">An item</li>
                    </ul> -->
                    <!-- <div class="card-body">
                        <a href="#" class="card-link">Card link</a>
                    </div> -->
                </div>
            </div>
            <!-- End Single post card -->
        </div>
    </div>
</template>

<script>
export default {
    name: 'Blogs',
    data: function() {
        return {
            blogs: []
            
        };
    },
    methods: {
        getBlogs: function() {
            
            
        },
    },
    created: function() {
        axios.get('/api/posts')
            .then((response)=>  {
                this.blogs = response.data.result
                console.log(response)
            });
        
    }
}
</script>