<template>
  <div class="form-container">
    <el-form
      ref="projectForm"
      :model="project"
      label-position="left"
      label-width="150px"
    >
      <el-form-item :label="$t('common.business_name')" prop="client_id">
        <el-select v-model="selectedClientID" placeholder="Please Select Client" :disabled="mode === 'view'">
            <el-option v-for="client in clients"
                      :key="client.id"
                      :label="client.business_name"
                      :value="client.id"
/>
        </el-select>
      </el-form-item>
      <el-form-item :label="$t('common.name')" prop="name">
        <el-input v-model="project.name" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('common.code')" prop="code">
        <el-input v-model="project.code" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('project.location')" prop="location">
        <el-input v-model="project.location" :disabled="mode === 'view'" />
      </el-form-item>
      <el-form-item :label="$t('common.description')" prop="description">
        <el-input v-model="project.description" :disabled="mode === 'view'" />
      </el-form-item>

      <el-form-item :label="$t('common.start_date')">
        <el-date-picker v-model="project.start_date" type="date"
                        placeholder="Pick a date" format="yyyy-MM-dd"
                        value-format="yyyy-MM-dd" :disabled="mode === 'view'"
/>
      </el-form-item>
      <el-form-item :label="$t('common.end_date')">
        <el-date-picker v-model="project.end_date" type="date"
                        placeholder="Pick a date" format="yyyy-MM-dd"
                        value-format="yyyy-MM-dd" :disabled="mode === 'view'"
/>
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
  name: 'ProjectForm',
  props: ['project', 'mode'],
  data() {
    return {
      selectedClientID: null,
      clients: [],
    }
  },
  async mounted(){
    var models = ['Client'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      console.log(data);
      this.clients = data[0];
      console.log('mounted', this.clients);
    });
  },
  
  methods: {
    cancelled(){
      this.$router.push('/project/projects');
    },
    async handleSubmit() {
      console.log('handleSubmit:', this.project)
      this.project.client_id = this.selectedClientID;
      this.project.status = 'active';
      if (this.project.id !== undefined) {
        axios
          .put('api/projects/'+this.project.id, this.project)
          .then(response => {
            this.$router.push('/project/projects');
            this.$message({
              type: 'success',
              message: 'Project info has been updated successfully',
              duration: 5 * 1000,
            });
          })
          .catch(error => {
            console.log('error:', error);
            showErrors(error);
          });
      } else {
        axios
          .post('api/projects', this.project)
          .then(response => {
            this.$router.push('/project/projects');
            this.$message({
              message: 'New project ' + this.project.name + ' ' + this.project.code + ' has been created successfully.',
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