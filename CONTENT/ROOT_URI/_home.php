<?php if($_SESSION['LoggedIn']){ ?>
<div class="hi" id="vapp">
    <div class="container">
        <h1 style="text-align:center;">{{msg}}</h1>
        <hr>
        <div class="alert alert-warning" v-if="showLoader">Loading...</div>
         <div v-if="showDismissibleAlert" class="alert alert-warning" variant="danger" dismissible>
          {{ noticeAlert }}
        </div>
        <!-- <pulse-loader :loading="false" :color="color" :size="size"></pulse-loader> -->
        <div class="card cc" v-for="blog in blogs" v-bind:key="blog.blog_ID">
            <div class="card-body">
                <h5 class="card-text">{{blog.TITLE}}</h5>
                <h5 class="card-title"><strong>{{blog.SLUG}}</strong></h5><br>
                <div class="btn-group mt-3">
                  <a :href="'/editBlog?blogId=' + blog.BLOG_ID" class="clWhite"><button class="btn btn-primary clWhite">View / Edit Blog</button></a>
                  <button class="btn btn-danger clWhite" v-on:click="deleteblog(blog.BLOG_ID)"><i class="fa fa-trash" aria-hidden="true"></i> Delete Blog</button>
                </div>
            </div>
        </div><br>  
    </div>
</div>


<script>
// import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

const vueApp = new Vue({
  el: '#vapp',
  data () {
    return {
      msg: 'Code With Bogo Blog Management',
      blogs: '',
      noticeAlert: null,
      showDismissibleAlert : false,
      showDomain:null,
      showLoader:false,
    }
  },
  methods: {
   deleteblog(id){
     var self = this;
     if(confirm('are you sure?')){
       let formData = new FormData();
        formData.append('blogId', id);
        formData.append('deleteBlog', "delete");
        fetch("/API/V1/", {
          method: "POST",
          body:formData,
        }).then(
            function(response) {
            response.json().then(function(data) {
              self.noticeAlert = data;
              self.showDismissibleAlert = true;
              self.fetchData();
            });
          }
        )
        .catch(function(err) {
          console.log('Fetch Error :-S', err);
        });
     }
   },
   fetchData(){
    this.showLoader = true;
    let self = this;
    fetch('/API/V1/?allblogs')
        .then(
          function(response) {
            if (response.status !== 200) {
              console.log('Looks like there was a problem. Status Code: ' +
                response.status);
              return;
            }
            // Examine the text in the response
            response.json().then(function(data) {
              self.showLoader = false;
              if(data){
                self.blogs = data;
              }else{
                self.noticeAlert = "No blog present. Please create one!";
                self.showDismissibleAlert = true;
                self.blogs = null;
              }
              
            });
          }
        )
        .catch(function(err) {
          console.log('Fetch Error :-S', err);
        });
   }
  },
  created: function(){
    this.fetchData()
  }
})
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.container{
  text-align: left;
}
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
.cc{
  margin-bottom: 20px;
}
.clWhite{
  color: #ffffff;
  text-decoration:none;
}
</style>

<?php 
}else{
  include 'signIn.php';
}

 ?>