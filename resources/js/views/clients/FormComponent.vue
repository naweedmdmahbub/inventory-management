<template>
  <div class="form-container">
    <el-form
      ref="clientForm"
      :model="client"
      label-position="left"
      label-width="150px"
    >
      <el-form-item :label="$t('client.first_name')" prop="first_name">
        <el-input v-model="client.first_name" :disabled="mode === 'show'" />
      </el-form-item>
      <el-form-item :label="$t('client.last_name')" prop="last_name">
        <el-input v-model="client.last_name" :disabled="mode === 'show'" />
      </el-form-item>
      <el-form-item :label="$t('client.business_name')" prop="business_name">
        <el-input v-model="client.business_name" :disabled="mode === 'show'" />
      </el-form-item>
      <el-form-item :label="$t('client.email')" prop="email">
        <el-input v-model="client.email" :disabled="mode === 'show'" />
      </el-form-item>
      <el-form-item :label="$t('client.contact_person')" prop="contact_person">
        <el-input v-model="client.contact_person" :disabled="mode === 'show'" />
      </el-form-item>
      <el-form-item :label="$t('client.contact_no')" prop="contact_no">
        <el-input v-model="client.contact_no" :disabled="mode === 'show'" />
      </el-form-item>
      <el-form-item :label="$t('client.address')" prop="address">
        <el-input v-model="client.address" :disabled="mode === 'show'" />
      </el-form-item>

      <el-form-item>
        <el-button type="primary" @click="handleSubmit">Create</el-button>
        <el-button>Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  name: 'ClientForm',
  props: ['client', 'mode'],
  data() {
    return {
      isMounted: false,
      errors: [],
    }
  },
  methods: {
    async handleSubmit() {
      this.errors = [];
      let data = new FormData();
      await data.append('image', this.client.image);
      for (var key in this.client) {
        data.append(key, this.client[key]);
      }
      if (this.client.id !== undefined) {
        axios
          .put('api/clients/'+this.client.id, this.client)
          .then(response => {
            this.$router.push('/administrator/clients');
            this.$message({
              type: 'success',
              message: 'Client info has been updated successfully',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            console.log('error:', error);
            this.showErrors(error);
          });
      } else {
        axios
          .post('api/clients', data)
          .then(response => {
            this.$router.push('/administrator/clients');
            this.$message({
              message: 'New client ' + this.client.first_name + ' ' + this.client.last_name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            this.showErrors(error);
          });
      }
    },
    showErrors(error){
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
    }
  }
}
</script>

<style>

</style>