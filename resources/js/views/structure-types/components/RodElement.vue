<template>
  <tr>
    <td>
      <el-row :gutter="20">
          <el-col :span="11" :offset="1">
            <el-form-item :label="$t('work.workTypeItem')" prop="name">
              <el-input v-model="workTypeItem.name" :disabled="mode === 'view'" />
            </el-form-item>
          </el-col>
          <el-col :span="11" :offset="1">
              <el-form-item :label="$t('common.description')" prop="description">
                  <el-input v-model="workTypeItem.description" type="textarea" :placeholder="$t('common.description')" />
              </el-form-item>
          </el-col>
      </el-row>

      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.dia')" prop="dia">
                  <el-input v-model="workTypeItem.dia" :placeholder="$t('work.dia')" @change="calculateCuttingLength" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.rod_length')" prop="rod_length">
                  <el-input v-model="workTypeItem.rod_length" :placeholder="$t('work.rod_length')" @change="calculateCuttingLength" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.lap')" prop="lap">
                  <el-input v-model="workTypeItem.lap" :placeholder="$t('work.lap')" @change="calculateCuttingLength" />
              </el-form-item>
          </el-col>
      </el-row>
      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.matam')" prop="matam">
                  <el-input v-model="workTypeItem.matam" :placeholder="$t('work.matam')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.cutting_length')" prop="cutting_length">
                  <el-input v-model="workTypeItem.cutting_length" :disabled="true" :placeholder="$t('work.cutting_length')" />
              </el-form-item>
          </el-col>
      </el-row>

              
      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.nos')" prop="nos">
                  <el-input v-model="workTypeItem.nos" :placeholder="$t('work.nos')" @change="calculateCuttingLength" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.layer')" prop="layer">
                  <el-input v-model="workTypeItem.layer" :placeholder="$t('work.layer')" @change="calculateCuttingLength" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.item')" prop="item">
                  <el-input v-model="workTypeItem.item" :placeholder="$t('work.item')" @change="calculateCuttingLength" />
              </el-form-item>
          </el-col>
      </el-row>
      <el-row :gutter="20">
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.total_length')" prop="total_length">
                  <el-input v-model="workTypeItem.total_length" :disabled="true" :placeholder="$t('work.total_length')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.unit_weight')" prop="unit_weight">
                  <el-input v-model="workTypeItem.unit_weight" :disabled="true" :placeholder="$t('work.unit_weight')" />
              </el-form-item>
          </el-col>
          <el-col :span="7" :offset="1">
              <el-form-item :label="$t('work.weight')" prop="weight">
                  <el-input v-model="workTypeItem.weight" :disabled="true" :placeholder="$t('work.weight')" />
              </el-form-item>
          </el-col>
      </el-row>
      
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
    this.workTypeItem.unit_weight = parseFloat(this.workTypeItem.dia * this.workTypeItem.dia / 162).toFixed(6);
  },
  async created(){
    console.log('workTypeItem create:', this.structureType);
  },
  
  methods: {
    calculateCuttingLength(){
      var item = this.workTypeItem;
      this.workTypeItem.cutting_length = parseFloat(item.rod_length)+ (parseFloat(item.lap)*(50*16)) + (parseFloat(item.matam)*2);
      console.log('calculateCuttingLength', item, this, parseFloat(item.dia), (parseFloat(item.lap)+(50*16)));
      this.calculateTotalLength();
    },
    calculateTotalLength(){
      var item = this.workTypeItem;
      this.workTypeItem.total_length = parseFloat((item.cutting_length * item.nos * item.layer * item.item) / 1000);
      this.workTypeItem.weight = parseFloat(item.unit_weight * item.total_length).toFixed(6);
      console.log('calculateTotalLength: ', this.workTypeItem);
    }
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