<template>
    <div>
        <form class="needs-validation" novalidate method="POST" action="/post/create">
            <div class="form-group">
                <label for="postTitleInput">Title</label>
                <input v-model="title" type="text" :class="{'form-control': true, 'is-invalid': errors.hasOwnProperty('title') && !title}" id="postTitleInput" aria-describedby="postTitleHelp" placeholder="Enter Post Title">
                <div v-if="errors.hasOwnProperty('title')" class="invalid-feedback">
                  <span v-for="error in errors.title">{{ error }} <br></span>
                </div>
            </div>
            <div class="form-group">
                <label for="postDescriptionInput">Description</label>
                <textarea v-model="description" class="form-control" id="postDescriptionInput" aria-describedby="postDescriptionHelp" placeholder="Enter Post Description" rows="10"></textarea>
                <small v-if="errors.hasOwnProperty('description') && !description" id="postDescriptionInput" class="form-text text-muted">
                  <span style="color: #dd3545" v-for="error in errors.description">{{ error }} <br></span>
                </small>
            </div>
            <button type="button" @click="create" class="btn btn-primary"><i :class="{fa: true,  'fa-plus': !isEditMode, 'fa-retweet': isEditMode}"></i>&nbsp;
              <span v-if="isEditMode">Update</span>
              <span v-else>Create</span>
            </button>
        </form>
    </div>
</template>

<script>
import Simditor from 'simditor'
import 'simditor/styles/simditor.css'
import axios from 'axios'

export default {
  name: 'create-post',
  props: {
    postData: {
      type: Object,
      required: false
    }
  },
  data () {
    return {
      isEditMode: false,
      title: '',
      description: '',
      errors: []
    }
  },
  watch: {
    // This small tweak is being used to add/remove border
    // around the text editor.
    description (val) {
      if (!val && this.errors.hasOwnProperty('description')) {
        $('.simditor').css('border', '1px solid #dd3545');
      } else {
        $('.simditor').css('border', '1px solid #c9d8db');
      }
    }
  },
  methods: {
    create () {
      let data = {
        title: this.title,
        description: this.description
      }
      let apiEndPoint = ''
      apiEndPoint = this.isEditMode ? '/api/post/update/' + this.postData.slug : '/api/post/create'

      axios.post(apiEndPoint, data).then(response => {
        if (response.data.hasOwnProperty('error')) {
          this.errors = response.data.error.attributes

          // Fix WISIWYG Editor Border color on Validation Error
          if (this.errors.hasOwnProperty('description')){
            $('.simditor').css('border', '1px solid #dd3545');
          }
        }

        if (response.data.hasOwnProperty('data')) {
          location.href = '/posts'
        }
      })
    }
  },
  mounted() {
    // Initializing the Editor
    var editor = new Simditor({
      textarea: $('#postDescriptionInput'),
      toolbar: [
      'title','bold','italic','underline','strikethrough','fontScale','color','ol','ul','blockquote','code','table','indent','outdent','alignment'
      ]
    });

    // Setting Description
    editor.on('valuechanged', (e, src) => {
      this.description = editor.getValue()
    })

    if (typeof this.postData !== 'undefined') {
      this.isEditMode = true
      this.title = this.postData.title
      editor.setValue(this.postData.description)
    }
  }
}
</script>
