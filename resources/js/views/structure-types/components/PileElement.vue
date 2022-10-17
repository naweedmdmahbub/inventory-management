<template>
  <tr>
    <td>
      <el-col :span="6">
        <el-form-item :label="$t('work.workTypeItem')" prop="name">
          <el-input v-model="workTypeItem.name" :disabled="mode === 'view'" />
        </el-form-item>
      </el-col>


      <el-col :span="18">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workTypeItem.description" :placeholder="$t('common.description')" />
              </el-form-item>
          </el-col>



          <el-col :span="7" :offset="1">
            <el-form-item :label="$t('common.unit_id')" prop="unit_id">
              <el-select v-model="workTypeItem.unit_id" placeholder="Please Select Unit" :disabled="mode === 'view'" width="100%">
                  <el-option v-for="unit in units"
                            :key="unit.id"
                            :label="unit.name"
                            :value="unit.id" />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.nos')" prop="nos">
                  <el-input v-model="workTypeItem.nos" :placeholder="$t('work.nos')" />
              </el-form-item>
          </el-col>

          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.length')" prop="length">
                  <el-input v-model="workTypeItem.length" :placeholder="$t('work.length')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.breadth')" prop="breadth">
                  <el-input v-model="workTypeItem.breadth" :placeholder="$t('work.breadth')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.height')" prop="height">
                  <el-input v-model="workTypeItem.height" :placeholder="$t('work.height')" />
              </el-form-item>
          </el-col>
          
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.weight')" prop="weight">
                  <el-input v-model="workTypeItem.weight" :placeholder="$t('work.weight')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.quantity')" prop="quantity">
                  <el-input v-model="workTypeItem.quantity" :placeholder="$t('work.quantity')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.total')" prop="total">
                  <el-input v-model="workTypeItem.total" :placeholder="$t('work.total')" />
              </el-form-item>
          </el-col>

      </el-col>

      
    </td>
  </tr>
</template>


<script>
import axios from 'axios';
export default {
  props: ['structureType', 'workTypeItem', 'mode'],
  data() {
    return {
      units: [],
    }
  },
  async mounted(){
    var models = ['Unit'];
    await axios.post('/api/get-model-data', models).then(({ data }) => {
      console.log(data);
      this.units = data[0];
      console.log('mounted', this.units);
    });
  },
  async created(){
    console.log('workTypeItem create:', this.structureType);
  },
  
  methods: {
  }
}
</script>

<style scoped>
  td {
    box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);
    border: .2px solid;
    padding: 8px;
    margin: 5px;
  }
</style>