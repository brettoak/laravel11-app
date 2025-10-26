<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting5 extends Component
{

    public $name;
    public $email;
    public $bio;
    public $isSaving = false;

    public function mount()
    {
        // 初始化数据（模拟加载用户信息）
        $this->name = "James";
        $this->email = "james@example.com";
        $this->bio = "PHP Developer";
    }



    public function save()
    {
        $this->isSaving = true;

        // 模拟保存延迟
        sleep(1);

        // 模拟保存完成
        $this->isSaving = false;

        // 发射事件通知父组件或页面刷新
        $this->dispatch('profileSaved');
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.service-greeting5');
    }
}
