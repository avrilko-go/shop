<?php
namespace app\admin\controller;

use catetree\catetree;
use think\Controller;
use think\Db;

class Cate extends Controller
{
    public function lst()
    {
        $data=db('cate')->order('sort desc')->select();
        $catetree=new catetree();
        $data=$catetree->sort($data);
        $this->assign('data',$data);
	    return view();
    }

    public function add(){
        if(request()->isPost()){
            $data=input('post.');
            if($data['pid']==2){
                $data['type']=3;
            }
            $this->checkAddData($data);
            $validate=validate('Cate');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $res=db('cate')->insert($data);
            if($res){
                $this->success('添加分类成功！',url('lst'));
            }else{
                $this->error('添加分类失败！');
            }
        }else{
            $cate=db('cate')->order('sort desc')->select();
            $catetree=new catetree();
            $cate=$catetree->sort($cate);
            $this->assign('cate',$cate);
            return view();
        }
    }

    public function edit($id){
        if(request()->isPost()){
            $data=input('post.');
            $validate=validate('Cate');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }
            $res=db('cate')->update($data);
            if($res!==false){
                $this->success('修改分类成功！',url('lst'));
            }else{
                $this->error('修改分类失败！');
            }
        }else{
            $data=db('cate')->find($id);
            $cate=db('cate')->order('sort desc')->select();
            $catetree=new catetree();
            $cate=$catetree->sort($cate);
            $this->assign('cate',$cate);
            $this->assign('data',$data);
            return view();
        }
    }

    public function del($id){
        $catetree=new catetree();
        $ids=$catetree->getChildId($id,'cate');
        $arrsys=[1,2,3];
        $res=array_intersect($ids,$arrsys);
        if($res){
            $this->error('不能删除系统内置分类');
        }

        Db::startTrans();
        try{
            foreach ($ids as $k=>$v){
                $result=db('cate')->delete($v);
                if(!$result){
                    throw new \Exception('删除栏目失败！');
                }
            }
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        $this->success('删除成功！','lst');
    }

    public function checkAddData($data){
        if(in_array($data['pid'],['1','3'])){
            $this->error('此分类不能添加子分类');
        }
        $pid=$data['pid'];
        $arr=db('cate')->where('id',$pid)->find();
        if($arr['pid']==2){
            $this->error('此分类不能添加子分类');
        }
    }

}
