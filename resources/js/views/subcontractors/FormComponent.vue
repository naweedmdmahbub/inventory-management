<template>
  <div class="form-container">
    <el-form
      ref="subcontractorForm"
      :model="subcontractor"
      label-position="left"
      label-width="150px"
    >
      <el-form-item :label="$t('user.first_name')" prop="first_name">
        <el-input v-model="subcontractor.first_name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.last_name')" prop="last_name">
        <el-input v-model="subcontractor.last_name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.business_name')" prop="business_name">
        <el-input v-model="subcontractor.business_name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.email')" prop="email">
        <el-input v-model="subcontractor.email" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.contact_person')" prop="contact_person">
        <el-input v-model="subcontractor.contact_person" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.contact_no')" prop="contact_no">
        <el-input v-model="subcontractor.contact_no" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('user.address')" prop="address">
        <el-input v-model="subcontractor.address" :disabled="mode === 'view'" />
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
  name: 'SubcontractorForm',
  props: ['subcontractor', 'mode'],
  data() {
    return {
    }
  },
  methods: {
    cancelled(){
      this.$router.push('/administrator/subcontractors');
    },
    async handleSubmit() {
      if (this.subcontractor.id !== undefined) {
        axios
          .put('api/subcontractors/'+this.subcontractor.id, this.subcontractor)
          .then(response => {
            this.$router.push('/administrator/subcontractors');
            this.$message({
              type: 'success',
              message: 'Subcontractor info has been updated successfully',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            console.log('error:', error);
            showErrors(error);
          });
      } else {
        axios
          .post('api/subcontractors', this.subcontractor)
          .then(response => {
            this.$router.push('/administrator/subcontractors');
            this.$message({
              message: 'New subcontractor ' + this.subcontractor.first_name + ' ' + this.subcontractor.last_name + ' has been created successfully.',
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