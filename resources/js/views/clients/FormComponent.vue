<template>
  <div class="form-container">
    <el-form
      ref="clientForm"
      :model="client"
      label-position="left"
      label-width="150px"
    >
      <el-form-item :label="$t('user.first_name')" prop="first_name">
        <el-input v-model="client.first_name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.last_name')" prop="last_name">
        <el-input v-model="client.last_name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.business_name')" prop="business_name">
        <el-input v-model="client.business_name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.email')" prop="email">
        <el-input v-model="client.email" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.contact_person')" prop="contact_person">
        <el-input v-model="client.contact_person" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.contact_no')" prop="contact_no">
        <el-input v-model="client.contact_no" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.address')" prop="address">
        <el-input v-model="client.address" :disabled="mode === 'view'" />
      </el-form-item>

      <el-form-item>
        <el-button v-if="mode === 'create'" type="primary" @click="handleSubmit">Create</el-button>
        <el-button v-if="mode === 'edit'" type="primary" @click="handleSubmit">Update</el-button>
        <el-button @click="cancelled">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import axios from 'axios';
import { showErrors } from '@/utils/helper.js'
export default {
  name: 'ClientForm',
  props: ['client', 'mode'],
  data() {
    return {
    }
  },
  methods: {
    cancelled(){
      this.$router.push('/administrator/clients');
    },
    async handleSubmit() {
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
            showErrors(error);
          });
      } else {
        axios
          .post('api/clients', this.client)
          .then(response => {
            this.$router.push('/administrator/clients');
            this.$message({
              message: 'New client ' + this.client.first_name + ' ' + this.client.last_name + ' has been created successfully.',
              type: 'success',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            showErrors(error);
          });
      }
    },
  }
}
</script>

<style>

</style>