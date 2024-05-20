<?php

namespace App\Http\Resources\Admin\Leafing;
use App\Models\JobCardHistory;
use App\Models\ModuleUser;
use Illuminate\Http\Resources\Json\JsonResource;

class LeafingResource extends JsonResource

{

    private function moduleUser($user, $id){
        $options = '<option selected="" value="">Oprator</option>';

        foreach (ModuleUser::where("module_id", 5)->get() as $alluser) {
            $options .= '<option value="' . $alluser->id . '" ' . ($user == $alluser->id ? 'selected' : '') . '>' . $alluser->name . '</option>';
        }

        return collect([
            'html' => '<div class="form-group">' .
                        '<select data-id="'. $id.'" class="form-select form-select-sm selectOprator" aria-label=".form-select-sm example">' .
                            $options .
                        '</select>' .
                    '</div>',
        ]);
    }


    function sheetSize($sheet_size, $warehouse_paper){
        if($warehouse_paper != ''){
            return '<p class=border-bottom "m-0">'.$sheet_size.'</p><p class="m-0 text-danger">'.$warehouse_paper.'</p>';
        }
        return $sheet_size;
    }

    function coating($coating, $other){
        $coating = explode(',', strip_tags($coating));
        $other = explode(',', strip_tags($other));

        if($other[0] == 'Metallic' || $other[0] == 'metallic'){
            return $coating[0] . ' + ' . $other[0]; 
        } else{
            return $coating[0]; 
        }
    }


    function totalSheet($totalSheet, $printedSheet, $other)
    {
        $other = explode(',', strip_tags($other));
        if($other[0] == 'Metallic' || $other[0] == 'metallic'){
            return $totalSheet; 
        } else{
            return $printedSheet; 
        }
    }

    function counter($jobCardId){
        if($jobCardId){
            $current_history = JobCardHistory::where(['job_card_id' => $jobCardId, 'machine'=>'Leafing'])->first();
            return $current_history->counter;
        }
        return 'N/A';
    }

    public function toArray($request)

    {
        $moduleUser = $this->moduleUser($this->user_id, $this->id);
        return [

            'sn' => ++$request->start,
            'id' => $this->id,
            'oprator' => $moduleUser['html'],           
            'user' => $this->user_id?$this->user->name:null,            
            'job_card_no'=>'<a class="text-danger" target="_blank" href="/admin/job-card/'.$this->jobCard->id.'">'.$this->jobCard->job_card_no."</a>",
            'set_no' => $this->jobCard->set_no,
            'emb_leaf' => $this->jobCard->embossing_leafing,
            'total_sheet' => $this->counter($this->jobCard->id),
            'file' => $this->jobCard->mediaFiles->count()>0?"<a class='glightbox' data-gallery='".$this->id."' href='".asset($this->jobCard->mediaFiles[0]['file'])."'> <img class='rounded avatar-sm' src='".asset($this->jobCard->mediaFiles[0]['file'])."'/></a>":"N/A",  
            'leafing_counter'=> $this->leafing_counter??'',
            'status'=> status($this->status_id),
            'status_id'=>$this->status_id,
            'job_card_id'=>$this->job_card_id,
            'file' => $this->jobCard->mediaFiles->count()>0?"<a class='glightbox' data-gallery='".$this->id."' href='".asset($this->jobCard->mediaFiles[0]['file'])."'> <img class='rounded avatar-sm' src='".asset($this->jobCard->mediaFiles[0]['file'])."'/></a>":"N/A",
            'carton_name'=>$this->job_card_id?getCartonNames(@$this->jobCard->jobCardItems):'',
        ];

    }

}

