<template>
    <section>
        <div class="container">
            <h1>{{ blog.title }}</h1>

            <div v-if="blog.category">Category: {{ blog.category.name }}</div>

            <div class="mb-2"><strong>Tags:</strong>
            <span v-for="tag in blog.tags" :key="tag.id" >
                {{ tag.name }}
            </span>
        </div>

            <p>{{ blog.content }}</p>
        </div>
    </section>
</template>

<script>
export default {
    name: 'blogDetails',
    data: function() {
        return {
            blog: false
        };
    },
    methods: {
        getPost() {
            axios.get('/api/posts/' + this.$route.params.slug)
            .then((response) => {
                if(response.data.success) {
                    this.blog = response.data.results;
                } else {
                    this.$router.push({ name: 'not-found' });
                }
                console.log(response);
            });
        }
    },
    created: function() {
        this.getPost();
    }
}
</script>