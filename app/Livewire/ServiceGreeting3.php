<?php

namespace App\Livewire;

use Livewire\Component;

class ServiceGreeting3 extends Component
{
    public array $columnDefs = [
        ['field' => 'id', 'headerName' => 'ID', 'sortable' => true, 'filter' => true, 'width' => 80],
        ['field' => 'name', 'headerName' => 'Name', 'sortable' => true, 'filter' => true, 'width' => 150],
        ['field' => 'email', 'headerName' => 'Email', 'sortable' => true, 'filter' => true, 'width' => 200],
        ['field' => 'created_at', 'headerName' => 'Created At', 'sortable' => true, 'filter' => true, 'width' => 1080],
    ];

    public array $tableData = [
        [
            'id' => 1,
            'name' => 'John Smith',
            'email' => 'zhangsan@example.com',
            'created_at' => '2024-01-15 10:30:00',
        ],
        [
            'id' => 2,
            'name' => 'Jane Doe',
            'email' => 'lisi@example.com',
            'created_at' => '2024-02-20 14:20:00',
        ],
        [
            'id' => 3,
            'name' => 'Bob Johnson',
            'email' => 'wangwu@example.com',
            'created_at' => '2024-03-10 09:15:00',
        ],
        [
            'id' => 4,
            'name' => 'Alice Williams',
            'email' => 'zhaoliu@example.com',
            'created_at' => '2024-04-05 16:45:00',
        ],
        [
            'id' => 5,
            'name' => 'Charlie Brown',
            'email' => 'sunqi@example.com',
            'created_at' => '2024-05-12 11:00:00',
        ],
        [
            'id' => 6,
            'name' => 'David Wilson',
            'email' => 'zhouba@example.com',
            'created_at' => '2024-06-18 13:30:00',
        ],
        [
            'id' => 7,
            'name' => 'Emma Davis',
            'email' => 'wujiu@example.com',
            'created_at' => '2024-07-22 15:10:00',
        ],
        [
            'id' => 8,
            'name' => 'Frank Miller',
            'email' => 'zhengshi@example.com',
            'created_at' => '2024-08-08 08:25:00',
        ],
        [
            'id' => 9,
            'name' => 'Grace Lee',
            'email' => 'qianyi@example.com',
            'created_at' => '2024-09-15 12:40:00',
        ],
        [
            'id' => 10,
            'name' => 'Henry Taylor',
            'email' => 'chener@example.com',
            'created_at' => '2024-10-01 10:55:00',
        ],
        [
            'id' => 11,
            'name' => 'Iris Anderson',
            'email' => 'chener@example.com',
            'created_at' => '2024-10-01 10:55:00',
        ],

    ];


    public function render()
    {
        return view('livewire.service-greeting3');
    }
}
