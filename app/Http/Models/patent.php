<?php
/**
 * Created by PhpStorm.
 * User: iamfitz
 * Date: 2018/6/7
 * Time: 21:43
 */

namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class patent extends Model
{
    protected $table = "patent";
    protected $primaryKey = "patent_id";

    public function patentList(string $title){
        return $this::whereRaw('MATCH(patent.title) AGAINST(? IN NATURAL LANGUAGE MODE)',$title)
                    ->join('expert','patent.expert_id','expert.expert_id')
                    ->select('patent_id','expert.expert_name','patent.expert_id','patent.title','information','supplynumber'
                        ,'supplydate','publicnumber','publicdate','supplyer','address','co_supplyer',
                        'inventor','intersupply','interrelease','enterdate','agency','agent','osupplynumber',
                        'provincenumber','mainitem','pages','mainclass','patentclass')
                    ->paginate(10);
    }
    public function patentInfo(int $id){
        return $this::where('patent_id',$id)
                    ->join('expert','patent.expert_id','expert.expert_id')
                    ->select('patent_id','expert.expert_name','patent.expert_id','patent.title','information','supplynumber'
                        ,'supplydate','publicnumber','publicdate','supplyer','address','co_supplyer',
                            'inventor','intersupply','interrelease','enterdate','agency','agent','osupplynumber',
                            'provincenumber','mainitem','pages','mainclass','patentclass')
                    ->get();
    }
    public function expertShow($expert_id){
        return $this->where('expert_id', $expert_id)->get();
    }

    public function expertMod($patent_id, $title, $information){
        return $this->where('patent_id', $patent_id)
            ->update(['title' => $title, 'information' => $information]);
    }

    public function expertAdd($expert_id, $title, $information){
        return $this->insertGetId(['expert_id' => $expert_id, 'title' => $title, 'information' => $information]);
    }

    public function expertDelete($patent_id){
        return $this->where('patent_id', $patent_id)->delete();
    }

    public function showRecommendPatent()
    {
        return $this->where('patent_id', '<', '20')->get();
    }
}
