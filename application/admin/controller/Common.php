<?php
namespace app\admin\controller;

class Common
{
    public function ajaxChangeStatus(){
        $id=input('post.id');
        $flied=input('post.flied');
        $tablename=input('post.tablename');
        $data=db($tablename)->where('id',$id)->find();
        if($tablename=='cate'){
            if($data['type']!=5){
                $ajax=[
                    'status'=>0,
                    'msg'=>'该类型的分类不允许修改状态！'
                ];
                return $ajax;
            }
        }
        if($data[$flied]==1){
            $save[$flied]=0;
            $flag=0;
        }elseif ($data[$flied]==0){
            $save[$flied]=1;
            $flag=1;
        }
        $res=db($tablename)->where('id',$id)->update($save);
        if($res){
            $ajax=[
                'status'=>1,
                'msg'=>'修改状态成功！',
                'flag'=>$flag
            ];
        }else{
            $ajax=[
                'status'=>0,
                'msg'=>'修改状态失败！',
                'flag'=>$flag
            ];
        }
        return $ajax;
    }

    public function ajaxChangeSort(){
        $id=input('post.id');
        $tablename=input('post.tablename');
        $sort=input('post.sort');
        $res=db($tablename)->where('id',$id)->update(['sort'=>$sort]);
        if($res!==false){
            $ajax=[
                'status'=>1,
                'msg'=>'修改排序成功！'
            ];
        }else{
            $ajax=[
                'status'=>0,
                'msg'=>'修改排序失败！'
            ];
        }
        return $ajax;
    }
}
