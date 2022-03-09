<template>
  <div class="form-container">
    <el-form
      ref="categoryForm"
      :model="category"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="category.name"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      <el-form-item label="Code" prop="code">
        <el-input
          v-model="category.code"
          :disabled="mode == 'show'"
        />
      </el-form-item>
      
      
      <el-form-item label="Image" prop="image">
        <img v-if="category.image !==null && category.image.id"
            :src="'/uploads/categories/' + category.image.filename"
            width="100"
            height="100"
        >
        <input type="file" @change="onFileChange">
      </el-form-item>
    </el-form>
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="dismissDialog">
        Cancel
      </el-button>
      <el-button
        v-if="mode !== 'show'"
        type="primary"
        @click="handleSubmit"
      >
        Confirm
      </el-button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  props: ['mode', 'category'],
  data() {
    return {
      loading: true,
      downloading: false,
      // url: '/uploads/categories/'+category.image.filename,
      imageUrl: '',
      errors: [],
    };
  },
  methods: {
    dismissDialog() {
      this.$emit('dismissDialog');
    },
    async handleSubmit() {
      this.errors = [];
      let data = new FormData();
      await data.append('image', this.category.image);
      for (var key in this.category) {
        data.append(key, this.category[key]);
      }
      console.log('data:', data, this.category);


      var offset = 0;
      if (this.category.id !== undefined) {
        axios
          .put('api/categories/'+this.category.id, this.category)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Category info has been updated successfully',
              duration: 5 * 1000,
            });
            this.dismissDialog();
          })
          .catch(error => {
            console.log('error:', error);
            this.errors = error.response.data.errors;
            Object.entries(this.errors).forEach(([key, value]) => {
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
          });
      } else {
        axios
          .post('api/categories', data)
          .then(response => {
            this.$message({
              message: 'New category ' + this.category.name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
            this.dismissDialog();
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            var offset = 0;
            Object.entries(this.errors).forEach(([key, value]) => {
              this.$notify.error({
                title: 'Error',
                message: value[0],
                offset: offset,
              });
              offset += 60;
            });
          });
      }
    },
    
    onFileChange(event){
        this.category.image = event.target.files[0];
        this.imageUrl = URL.createObjectURL(this.category.image);
        console.log('onFileChange: ', event.target.files);
        console.log('this.category.image: ', this.category.image);
        console.log('imageUrl: ', this.imageUrl);
        // this.imageUrl = event.target.files[0].name;
    },
  }
};
</script>
