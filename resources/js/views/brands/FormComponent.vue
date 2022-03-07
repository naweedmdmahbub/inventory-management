<template>
  <div class="form-container">
    <el-form
      ref="brandForm"
      :model="brand"
      label-position="left"
      label-width="150px"
      style="max-width: 500px;"
    >
      <el-form-item label="Name" prop="name">
        <el-input
          v-model="brand.name"
          :disabled="mood == 'show'"
        />
      </el-form-item>
      <el-form-item label="Code" prop="code">
        <el-input
          v-model="brand.code"
          :disabled="mood == 'show'"
        />
      </el-form-item>
      <el-form-item label="Description" prop="description">
        <el-input
          v-model="brand.description"
          type="textarea"
          :disabled="mood == 'show'"
        />
      </el-form-item>
      
      
      <el-form-item label="Image" prop="image">
        <!-- <img v-bind:src="'/uploads/brands/' + image.filename" />  -->
        <input type="file" @change="onFileChange">
      </el-form-item>

      <!-- <el-image
        style="width: 100px; height: 100px"
        :src="url"
        :fit="fit">
      </el-image> -->
    </el-form>
    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="dismissDialog">
        Cancel
      </el-button>
      <el-button
        v-if="mood !== 'show'"
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
  props: ['mood', 'brand'],
  data() {
    return {
      loading: true,
      downloading: false,
      url: '',
      // url: '/uploads/brands/'+brand.image.filename,
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
      await data.append('image', this.brand.image);
      for (var key in this.brand) {
        data.append(key, this.brand[key]);
      }
      console.log('data:', data, this.brand);


      var offset = 0;
      if (this.brand.id !== undefined) {
        axios
          .put('api/brands/'+this.brand.id, this.brand)
          .then(response => {
            this.$message({
              type: 'success',
              message: 'Brand info has been updated successfully',
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
          .post('api/brands', data)
          .then(response => {
            this.$message({
              message: 'New brand ' + this.brand.name + ' has been created successfully.',
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
        console.log(event.target.files);
        this.brand.image = event.target.files[0];
    },
  }
};
</script>
