<?php

namespace mini\core;

class View
{
    //定义成员属性
    protected $args;
    private $flag = 0;
    public $file;

    //加载视图
    public function view($index,$template=null)
    {
        //给模板变量赋值
        if(!$this->flag && !is_null($template)){
            $this->assign($template);
        }
        //使用渲染方法渲染模板
        $this->render(__VIEW__.$index,__ROOT__.'runtime/temp/');
    }

    //视图的渲染
    public function render($source,$destination)
    {
        //获取模板文件内容
        $contents = file_get_contents($source,FILE_USE_INCLUDE_PATH);
        //替换文件的内容
        $updateContents = str_replace("{\$","<?php echo htmlentities(\$this->args['",$contents);
        $updateContents = str_replace("}","'])?>",$updateContents);
        //将修改后的文件内容保存到另一个文件
        $this->file = time().'.php';
        file_put_contents($destination.$this->file,$updateContents);
        //重新加载文件
        require_once ''.$destination.$this->file.'';
    }

    //模板变量赋值
    public function assign($key,$value=null)
    {
        if(is_array($key)){
            $this->args = $key;
        }else{
            $this->args[$key] = $value;
        }
        $this->flag = 1;
    }
}