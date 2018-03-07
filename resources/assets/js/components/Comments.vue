<template>
  <div>
    <hr>
    <h5>
      <span>{{comments.length}}</span>
      <span v-if="comments.length === 1">Comment</span>
      <span v-else>Comments</span>
      <i class="fa fa-comments"></i>
    </h5>
    <div class="clearfix">
      <!-- show this comment input box if user logged-in -->
      <form v-if="authUser">
        <div class="form-group">
          <textarea v-model="commentBody" :class="{'form-control': true, 'is-invalid': errors.hasOwnProperty('body') && !commentBody}" id="commentBody" aria-describedby="postTitleHelp" rows="5" placeholder="Please say something!"></textarea>
          <div v-if="errors.hasOwnProperty('body')" class="invalid-feedback">
            <span v-for="error in errors.body">{{ error }} <br></span>
          </div>
        </div>
        <button type="button" @click="postComment" class="btn btn-primary float-right"><i class="fa fa-send"></i>&nbsp;Comment</button>
      </form>
      <!-- if user isn't logged-in then show login/register links -->
      <div v-else class="mt-4 mb-4 text-center">
        Please <a href="/login">Login</a>/<a href="/register">Register
        </a> to comment.
      </div>
    </div>
    <div>
      <!-- comments -->
      <div class="media-body">
        <div v-for="comment in comments">
          <h5 class="mt-0">{{ comment.user.name }}&nbsp;&nbsp;
            <!-- `v-date-to-human` directive used -->
            <label v-date-to-human="comment.created_at" style="color: #b5b5b5; font-size: 12px;">{{ comment.created_at }}</label>
          </h5>

          <!-- If user is logged in and the comment belongs to the logged-in user then show the delete button -->
          <a v-if="authUser && (authUser.id === comment.user_id)" href="javascript:;" @click="deleteComment(comment)">
            <i class="fa fa-times"></i>&nbsp;Delete
          </a>
          <p>{{ comment.body }}</p>
          <hr>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from 'moment'
export default {
  name: 'comments',
  props: {
    postId: {
      type: Number,
      required: true
    },
    commentData: {
      type: Array,
      required: true
    },
    authUser: {
      type: Object,
      required: false
    }
  },
  data () {
    return {
      commentBody: '',
      comments: this.commentData,
      errors: []
    }
  },
  methods: {
    deleteComment (comment) {
      let _this = this
      this.vex.dialog.confirm({
        message: 'Are you absolutely sure you want to delete the comment?',
        callback: (value) => {
          if (value) {
            axios.delete('/api/comment/' + comment.id).then(response => {
              if (response.data.hasOwnProperty('data')) {
                _this.comments = response.data.data.attributes;
              }
            })
          }
        }
      })
    },
    postComment () {
      axios.post('/api/comment/' + this.postId, {body: this.commentBody}).then(response => {
          // Validation error
          if (response.data.hasOwnProperty('error')) {
            this.errors = response.data.error.attributes
          }

          // Successfull Response
          if (response.data.hasOwnProperty('data')) {
            this.commentBody = null
            this.comments = response.data.data.attributes;
          }
      })
    }
  },
  directives: {
    // Being used to modify the datetime into human readable format (1 hours ago for e.g.,)
    dateToHuman (el, binding, vnode) {
      el.innerHTML = moment(binding.value).format('dddd Do, MMMM \'YY') + '&nbsp;(' +moment(binding.value).fromNow() + ')'
    }
  }
}
</script>