<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

class Brand extends Controller
{
    public function lst()
    {
        $data=db('brand')->paginate(8);
        $this->assign('data',$data);
	    return view();
    }

    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            $url=$data['url'];
            if($url && strpos($url,'http://')===false ){
                $data['url']='http://'.$url;
            }
            if($_FILES['img']['tmp_name']){
                $file=$this->upload('img');
                if($file){
                    $data['img']=$file;
                }
            }
            $validate=validate('Brand');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $res=db('brand')->insert($data);
            if($res){
                $this->success('添加品牌成功！','lst');
            }else{
                $this->error('添加品牌失败！');
            }
        }else{
            return view();
        }
    }

    public function edit($id){
        if(request()->isPost()){
            $data=input('post.');
            $url=$data['url'];
            if($url && strpos($url,'http://')===false ){
                $data['url']='http://'.$url;
            }
            if($_FILES['img']['tmp_name']){
                $file=$this->upload('img');
                $olddata=db('brand')->find(input('post.id'));
                $oldimg=IMG_UPLOADS.$olddata['img'];
                @unlink($oldimg);
                if($file){
                    $data['img']=$file;
                }
            }
            $validate=validate('Brand');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $res=db('brand')->update($data);
            if($res!==false){
                $this->success('修改品牌成功！','lst');
            }else{
                $this->error('修改品牌失败！');
            }
        }else{
            $data=db('brand')->find($id);
            $this->assign('data',$data);
            return view();
        }
    }

    public function del($id){
        $data=db('brand')->find($id);
        $img=IMG_UPLOADS.$data['img'];
        if($img){
            @unlink($img);
        }
        $res=db('brand')->delete($id);
        if($res){
            $this->success('删除品牌成功！');
        }else{
            $this->error('删除品牌失败！');
        }
    }

    //上传图片
    public function upload($name){
        $file = request()->file($name);
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'static'. DS .'uploads');
            if($info){
                return $info->getSaveName();
            }else{
                return false;
            }
        }
    }


}
