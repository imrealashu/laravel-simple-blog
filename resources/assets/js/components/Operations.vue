<template>
<div>
<button @click="deletePost(postData.slug)" class="pull-right btn btn-danger btn-sm"><i class="fa fa-times"></i>&nbsp;Delete</button>
<a class="pull-right mr-1" title="Edit Post" :href="'/post/edit/' + postData.slug"><button class="btn btn-sm btn-success"><i class="fa fa-edit"></i>&nbsp;Edit</button></a>
</div>
</template>
<script>
export default {
  name: 'operations',
  props: {
    postData: {
      type: Object,
      required: true
    }
  },
  methods: {
    deletePost (slug) {
      this.vex.dialog.confirm({
        message: 'Are you absolutely sure you want to delete this post?',
        callback: function (value) {
            if (value) {
              axios.delete('/api/post/delete/' + slug).then(response => {
                if(response.data.hasOwnProperty('data')) {
                  location.href = '/posts'
                }
              })
            }
        }
      })
    }
  }
}
</script>