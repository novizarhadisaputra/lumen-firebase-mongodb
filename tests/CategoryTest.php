<?php

class CategoryTest extends TestCase
{
    public function testShouldReturnAllCategory()
    {

        $this->get('/api/category', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'message',
            'data' => [
                'category' => [
                    [
                        'name',
                        'updated_at',
                        'created_at',
                    ],
                ],
            ],
        ]);

    }

    public function testShouldReturnCategory()
    {
        $this->get('/api/category/5fd2cbec2e58000032000e83', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'message',
                'data' => [
                    'category'
                ],
            ]
        );

    }

    /**
     * //api/category [POST]
     */
    public function testShouldCreateCategory()
    {
        $parameters = [
            'name' => 'Elektronik',
        ];

        $this->post('/api/category', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'message',
                'data' => [
                    'category'
                ],
            ]
        );

    }

    /**
     * //api/category/id [PUT]
     */
    public function testShouldUpdateCategory()
    {

        $parameters = [
            'name' => 'Otomotif'
        ];

        $this->put('/api/category/5fd2cbec2e58000032000e83', $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'message',
                'data' => [
                    'category'
                ],
            ]
        );
    }

    /**
     * //api/category/id [DELETE]
     */
    public function testShouldDeleteCategory()
    {

        $this->delete('/api/category/5fd313648b6e0000620069f2', [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            [
                'message',
            ]
        );
    }

}
