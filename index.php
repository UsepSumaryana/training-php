<?php

const CODE_SUCCESS = 200;
const CODE_FAILED = 401;
const CODE_NOT_FOUND = 404;
const MESSAGE_SUCCESS = 'Success';
const MESSAGE_FAILED = 'Failed';
const MESSAGE_NOT_FOUND = 'Not Found';
const MESSAGE_FOUND = 'Data ditemukan';
const MESSAGE_INVALID_DATA = 'Invalid data';
const MESSAGE_ENDPOINT_NOTFOUND = 'Endpoint not found';

class Result
{
    public $code;
    public $message;
    public $data;

    public function __construct($code = 200, $message = 'OK', $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function toArray()
    {
        return array(
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        );
    }

    public function toJson()
    {
        exit(json_encode(array(
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data
        )));
    }
}

class Utils
{
    public function convertPriceToWords($price)
    {
        $price = abs($price);
        $words = [
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        ];

        $sentence = "";

        if ($price < 12) {
            $sentence = " " . $words[$price];
        } elseif ($price < 20) {
            $sentence = $this->convertPriceToWords($price - 10) . " belas";
        } elseif ($price < 100) {
            $sentence = $this->convertPriceToWords($price / 10) . " puluh" . $this->convertPriceToWords($price % 10);
        } elseif ($price < 200) {
            $sentence = " seratus" . $this->convertPriceToWords($price - 100);
        } elseif ($price < 1000) {
            $sentence = $this->convertPriceToWords($price / 100) . " ratus" . $this->convertPriceToWords($price % 100);
        } elseif ($price < 2000) {
            $sentence = " seribu" . $this->convertPriceToWords($price - 1000);
        } elseif ($price < 1000000) {
            $sentence = $this->convertPriceToWords($price / 1000) . " ribu" . $this->convertPriceToWords($price % 1000);
        } elseif ($price < 1000000000) {
            $sentence = $this->convertPriceToWords($price / 1000000) .
            " juta" . $this->convertPriceToWords($price % 1000000);
        } elseif ($price < 1000000000000) {
            $sentence = $this->convertPriceToWords($price / 1000000000) .
            " milyar" . $this->convertPriceToWords(fmod($price, 1000000000));
        } elseif ($price < 1000000000000000) {
            $sentence = $this->convertPriceToWords($price / 1000000000000) .
            " trilyun" . $this->convertPriceToWords(fmod($price, 1000000000000));
        }

        return $sentence;
        
    }

    public function makeItRupiah($price)
    {

        return "Rp " . number_format($price, 2, ',', '.');

    }
}

class ZooKeeperManager
{
    private $zooKeepers;

    public function __construct()
    {
        $this->zooKeepers = [
                [
                    'id' => 1,
                    'name' => 'usep',
                    'birth_date' => '03-07-2000',
                    'phone_number' => '082214922123',
                    'email' => 'sepu@gmail.mail',
                    'salary' => 10000000000000000
                ],
                [
                    'id' => 2,
                    'name' => 'John',
                    'birth_date' => '10-12-1995',
                    'phone_number' => '081234567890',
                    'email' => 'john@example.com',
                    'salary' => 5000000
                ],
                [
                    'id' => 3,
                    'name' => 'Alice',
                    'birth_date' => '05-06-1988',
                    'phone_number' => '085678901234',
                    'email' => 'alice@example.com',
                    'salary' => 8000000
                ],
                [
                    'id' => 4,
                    'name' => 'Michael',
                    'birth_date' => '08-03-1990',
                    'phone_number' => '081122334455',
                    'email' => 'michael@example.com',
                    'salary' => 6000000
                ],
                [
                    'id' => 5,
                    'name' => 'Emily',
                    'birth_date' => '12-07-1993',
                    'phone_number' => '087654321098',
                    'email' => 'emily@example.com',
                    'salary' => 7000000
                ],
                [
                    'id' => 6,
                    'name' => 'David',
                    'birth_date' => '02-09-1985',
                    'phone_number' => '089876543210',
                    'email' => 'david@example.com',
                    'salary' => 9000000
                ]
            ];

    }

    public function addZooKeeper($zooKeeper)
    {
        $this->zooKeepers[] = $zooKeeper;
        return $this->findZooKeeper($zooKeeper['id']);
    }

    public function removeZooKeeper($zooKeeper)
    {
        $index = array_search($zooKeeper, $this->zooKeepers);
        if ($index !== false) {

            array_splice($this->zooKeepers, $index, 1);
            return true;

        } else {

            return false;

        }
    }

    public function getZooKeepers()
    {
        return $this->zooKeepers;
    }

    public function countZooKeepers()
    {
        return count($this->zooKeepers);
    }

    public function findZooKeeper($id)
    {
        foreach ($this->zooKeepers as $zooKeeper) {

            if ($zooKeeper['id'] === $id) {

                return $zooKeeper;

            }

        }

        return null;
    }

    public function updateZooKeeper($id, $newData)
    {
        
        foreach ($this->zooKeepers as &$zooKeeper) {

            if ($zooKeeper['id'] === $id) {

                $zooKeeper['name'] = $newData['name'];
                $zooKeeper['birth_date'] = $newData['birth_date'];
                $zooKeeper['phone_number'] = $newData['phone_number'];
                $zooKeeper['email'] = $newData['email'];
                $zooKeeper['salary'] = $newData['salary'];
                return $this->findZooKeeper($zooKeeper['id']);

            }

        }
        
        return false;

    }

    public function getZooKeepersHandler()
    {

        $result = new Result();

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->zooKeepers;

        return $result->toJson();

    }

    public function addZooKeeperHandler($data)
    {

        $result = new Result();

        if ($data && isset($data['name'])) {

            $zooKeeper = [
                'id' => mt_rand(1, 9999999999),
                'name' => $data['name'],
                'birth_date' => $data['birth_date'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'salary' => $data['salary'],
            ];

            $resData = $this->addZooKeeper($zooKeeper);
            $result->code = CODE_SUCCESS;
            $result->message = MESSAGE_SUCCESS;
            $result->data = $resData;

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_FAILED;

        }

        return $result->toJson();
    }

    public function updateZooKeeperHandler($data)
    {
        
        $result = new Result();
        if ($data && isset($data['name'])) {
            $id = $data['id'];
            $zooKeeper = [
                'id' => $data['id'],
                'name' => $data['name'],
                'birth_date' => $data['birth_date'],
                'phone_number' => $data['phone_number'],
                'email' => $data['email'],
                'salary' => $data['salary'],
            ];

            $resData = $this->updateZooKeeper($id, $zooKeeper);

            if ($resData) {
                
                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();

    }

    public function removeZooKeeperHandler($id)
    {
        $result = new Result();
        $zooKeeper = $this->findZooKeeper($id);
        if ($zooKeeper) {

            if ($this->removeZooKeeper($zooKeeper)) {
                
                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }
            
        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }
    }

}

class AnimalManager
{
    private $animals;

    public function __construct()
    {
        $this->animals = [
                [
                    'id' => 1,
                    'nama' => 'Singa',
                    'jenis' => 'Karnivora',
                    'habitat' => 'Savana',
                    'jumlah_kaki' => 4
                ],
                [
                    'id' => 2,
                    'nama' => 'Gajah',
                    'jenis' => 'Herbivora',
                    'habitat' => 'Hutan',
                    'jumlah_kaki' => 4
                ],
                [
                    'id' => 3,
                    'nama' => 'Kuda',
                    'jenis' => 'Herbivora',
                    'habitat' => 'Padang Rumput',
                    'jumlah_kaki' => 4
                ],
                [
                    'id' => 4,
                    'nama' => 'Buaya',
                    'jenis' => 'Karnivora',
                    'habitat' => 'Air Tawar',
                    'jumlah_kaki' => 4
                ],
                [
                    'id' => 5,
                    'nama' => 'Kucing',
                    'jenis' => 'Karnivora',
                    'habitat' => 'Rumah',
                    'jumlah_kaki' => 4
                ]
            ];

    }

    public function addAnimal($zooKeeper)
    {
        $this->animals[] = $zooKeeper;
        return $this->findAnimal($zooKeeper['id']);
    }

    public function removeAnimal($zooKeeper)
    {
        $index = array_search($zooKeeper, $this->animals);
        if ($index !== false) {

            array_splice($this->animals, $index, 1);
            return true;

        } else {

            return false;

        }
    }

    public function getAnimals()
    {
        return $this->animals;
    }

    public function countAnimals()
    {
        return count($this->animals);
    }

    public function findAnimal($id)
    {
        foreach ($this->animals as $zooKeeper) {
            if ($zooKeeper['id'] === $id) {
                return $zooKeeper;
            }
        }
        return null;
    }

    public function updateAnimal($id, $newData)
    {
        
        foreach ($this->animals as &$animal) {

            if ($animal['id'] === $id) {

                $animal['nama'] = $newData['nama'];
                $animal['jenis'] = $newData['birth_date'];
                $animal['habitat'] = $newData['phone_number'];
                $animal['jumlah_kaki'] = $newData['jumlah_kaki'];
                return $this->findAnimal($animal['id']);

            }

        }

        return false;

    }

    public function getAnimalsHandler()
    {

        $result = new Result();

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->animals;

        return $result->toJson();

    }

    public function addAnimalHandler($data)
    {

        $result = new Result();

        if ($data && isset($data['nama'])) {

            $animal = [
                'id' => mt_rand(1, 9999999999),
                'nama' => $data['nama'],
                'jenis' => $data['jenis'],
                'habitat' => $data['habitat'],
                'jumlah_kaki' => $data['jumlah_kaki'],
            ];

            $resData = $this->addAnimal($animal);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }
            

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();
    }

    public function updateAnimalHandler($data)
    {
        
        $result = new Result();
        if ($data && isset($data['nama'])) {
            $id = $data['id'];
            $zooKeeper = [
                'id' => mt_rand(1, 9999999999),
                'nama' => $data['nama'],
                'jenis' => $data['jenis'],
                'habitat' => $data['habitat'],
                'jumlah_kaki' => $data['jumlah_kaki'],
            ];

            $resData = $this->updateAnimal($id, $zooKeeper);
            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;
            
        }

        return $result->toJson();

    }

    public function removeAnimalHandler($id)
    {

        $result = new Result();
        $zooKeeper = $this->findAnimal($id);

        if ($zooKeeper) {

            if ($this->removeAnimal($zooKeeper)) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }
    }

}

class CageManager
{
    private $cages;

    public function __construct()
    {
        $this->cages = [
                [
                    'id' => 1,
                    'nama' => 'Cage 1',
                    'ukuran' => '5m x 5m',
                    'jenis_binatang' => 'Singa',
                    'kapasitas' => 2
                ],
                [
                    'id' => 2,
                    'nama' => 'Cage 2',
                    'ukuran' => '8m x 6m',
                    'jenis_binatang' => 'Gajah',
                    'kapasitas' => 3
                ],
                [
                    'id' => 3,
                    'nama' => 'Cage 3',
                    'ukuran' => '4m x 4m',
                    'jenis_binatang' => 'Kuda',
                    'kapasitas' => 1
                ],
                [
                    'id' => 4,
                    'nama' => 'Cage 4',
                    'ukuran' => '6m x 6m',
                    'jenis_binatang' => 'Buaya',
                    'kapasitas' => 2
                ],
                [
                    'id' => 5,
                    'nama' => 'Cage 5',
                    'ukuran' => '3m x 3m',
                    'jenis_binatang' => 'Kucing',
                    'kapasitas' => 1
                ]
            ];

    }

    public function addCage($cage)
    {
        $this->cages[] = $cage;
        return $this->findCage($cage['id']);
    }

    public function removeCage($cage)
    {

        $index = array_search($cage, $this->cages);
        if ($index !== false) {

            array_splice($this->cages, $index, 1);
            return true;

        }

        return false;
    }

    public function getCages()
    {
        return $this->cages;
    }

    public function countCages()
    {
        return count($this->cages);
    }

    public function findCage($id)
    {
        foreach ($this->cages as $cage) {
            if ($cage['id'] === $id) {
                return $cage;
            }
        }
        return null;
    }

    public function updateCage($id, $newData)
    {
        
        foreach ($this->cages as &$cage) {

            if ($cage['id'] === $id) {

                $cage['nama'] = $newData['nama'];
                $cage['ukuran'] = $newData['ukuran'];
                $cage['jenis_binatang'] = $newData['jenis_binatang'];
                $cage['kapasitas'] = $newData['kapasitas'];
                return $this->findCage($cage['id']);

            }

        }

        return false;

    }

    public function getCagesHandler()
    {
        $result = new Result();

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->cages;

        return $result->toJson();

    }

    public function addCageHandler($data)
    {

        $result = new Result();

        if ($data && isset($data['nama'])) {

            $cage = [
                'id' => mt_rand(1, 9999999999),
                'nama' => $data['nama'],
                'ukuran' => $data['ukuran'],
                'jenis_binatang' => $data['jenis_binatang'],
                'kapasitas' => $data['kapasitas'],
            ];

            $resData = $this->addCage($cage);
            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();
    }

    public function updateCageHandler($data)
    {
        
        $result = new Result();
        if ($data && isset($data['nama'])) {
            $id = $data['id'];
            $cage = [
                'id' => mt_rand(1, 9999999999),
                'nama' => $data['nama'],
                'ukuran' => $data['ukuran'],
                'jenis_binatang' => $data['jenis_binatang'],
                'kapasitas' => $data['kapasitas'],
            ];

            $res = $this->updateCage($id, $cage);

            if ($res) {
                
                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $res;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();

    }

    public function removeCageHandler($id)
    {

        $result = new Result();
        $cage = $this->findCage($id);

        if ($cage) {

            if ($this->removeCage($id)) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;

            }

        } else {
            
            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();

    }

}

class VisitorManager
{
    private $visitors;

    public function __construct()
    {
        $this->visitors = [
                [
                    'id' => 1,
                    'nama' => 'John Doe',
                    'umur' => 25,
                    'jenis_kelamin' => 'Laki-laki',
                    'tanggal_kunjungan' => '2023-05-24'
                ],
                [
                    'id' => 2,
                    'nama' => 'Jane Smith',
                    'umur' => 30,
                    'jenis_kelamin' => 'Perempuan',
                    'tanggal_kunjungan' => '2023-05-21'
                ],
                [
                    'id' => 3,
                    'nama' => 'Michael Johnson',
                    'umur' => 40,
                    'jenis_kelamin' => 'Laki-laki',
                    'tanggal_kunjungan' => '2023-05-26'
                ],
                [
                    'id' => 4,
                    'nama' => 'Emily Brown',
                    'umur' => 28,
                    'jenis_kelamin' => 'Perempuan',
                    'tanggal_kunjungan' => '2023-05-27'
                ],
                [
                    'id' => 5,
                    'nama' => 'David Wilson',
                    'umur' => 35,
                    'jenis_kelamin' => 'Laki-laki',
                    'tanggal_kunjungan' => '2023-05-28'
                ]
            ];

    }

    public function addVisitor($visitor)
    {

        $this->visitors[] = $visitor;
        return $this->findVisitor($visitor['id']);

    }

    public function removeVisitor($visitor)
    {
        
        $index = array_search($visitor, $this->visitors);
        if ($index !== false) {

            array_splice($this->visitors, $index, 1);
            return true;

        } else {

            return false;

        }

    }

    public function getVisitors()
    {
        return $this->visitors;
    }

    public function countVisitors()
    {

        return count($this->visitors);

    }

    public function getAverageAge()
    {

        $totalAge = 0;
        foreach ($this->visitors as $visitor) {
            $totalAge += $visitor['umur'];
        }

        return count($this->visitors) > 0 ? $totalAge / count($this->visitors) : 0;

    }

    public function findVisitor($id)
    {
        foreach ($this->visitors as $visitor) {

            if ($visitor['id'] === $id) {
                return $visitor;
            }

        }
        return null;
    }

    public function updateVisitor($id, $newData)
    {
        
        foreach ($this->visitors as &$visitor) {
            if ($visitor['id'] === $id) {
                $visitor['nama'] = $newData['nama'];
                $visitor['umur'] = $newData['umur'];
                $visitor['jenis_kelamin'] = $newData['jenis_kelamin'];
                $visitor['tanggal_kunjungan'] = $newData['tanggal_kunjungan'];

                $this->visitors[] = $visitor;
                return $this->findVisitor($id);
            }
        }
        return false;

    }

    public function getVisitorsHandler()
    {

        $result = new Result();
        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->visitors;
        return $result->toJson();

    }

    public function addVisitorHandler($data)
    {

        $result = new Result();

        if ($data && isset($data['nama'])) {

            $visitor = [
                'id' => mt_rand(1, 9999999999),
                'nama' => $data['nama'],
                'umur' => $data['umur'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_kunjungan' => $data['tanggal_kunjungan'],
            ];

            $resData = $this->addVisitor($visitor);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();

    }

    public function updateVisitorHandler($data)
    {

        $result = new Result();
        
        if ($data && isset($data['nama'])) {

            $id = $data['id'];
            $visitor = [
                'nama' => $data['nama'],
                'umur' => $data['umur'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_kunjungan' => $data['tanggal_kunjungan'],
            ];

            $resData = $this->updateVisitor($id, $visitor);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }

        } else {

            $result->code = CODE_SUCCESS;
            $result->message = MESSAGE_INVALID_DATA;
            $result->data = null;

        }

        return $result->toJson();

    }

    public function removeVisitorHandler($id)
    {

        $result = new Result();
        
        $visitor = $this->findVisitor($id);
        if ($visitor) {

            if ($this->removeVisitor($visitor)) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = null;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = null;

            }
            

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;
            $result->data = null;

        }

        return $result->toJson();

    }

    public function getAverageAgeHandler()
    {

        $result = new Result();
        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->getAverageAge();
        
    }

}

class TicketManager
{
    private $tickets;

    public function __construct()
    {
        $this->tickets = [
                [
                    'ticketId' => 'TICK001',
                    'price' => 10,
                    'title' => 'The Jungle',
                    'description' => 'Ticket promo selama Februari',
                    'expiredDate' => '2023-05-20'
                ],
                [
                    'ticketId' => 'TICK002',
                    'price' => 15,
                    'title' => 'Safari Adventure',
                    'description' => 'Tiket masuk untuk pengalaman safari',
                    'expiredDate' => '2023-05-25'
                ],
                [
                    'ticketId' => 'TICK003',
                    'price' => 20,
                    'title' => 'Penguin Paradise',
                    'description' => 'Tiket masuk ke dunia penguin',
                    'expiredDate' => '2023-06-01'
                ],
                [
                    'ticketId' => 'TICK004',
                    'price' => 12,
                    'title' => 'Birds of Paradise',
                    'description' => 'Tiket masuk ke tempat pemuliaan burung-burung eksotis',
                    'expiredDate' => '2023-05-28'
                ],
                [
                    'ticketId' => 'TICK005',
                    'price' => 8,
                    'title' => 'Butterfly Garden',
                    'description' => 'Tiket masuk ke taman kupu-kupu',
                    'expiredDate' => '2023-05-23'
                ],
                [
                    'ticketId' => 'TICK006',
                    'price' => 18,
                    'title' => 'Dolphin Show',
                    'description' => 'Tiket masuk untuk menonton pertunjukan lumba-lumba',
                    'expiredDate' => '2023-06-03'
                ],
                [
                    'ticketId' => 'TICK007',
                    'price' => 25,
                    'title' => 'Giraffe Encounter',
                    'description' => 'Tiket masuk untuk berinteraksi dengan jerapah',
                    'expiredDate' => '2023-05-29'
                ],
                [
                    'ticketId' => 'TICK008',
                    'price' => 30,
                    'title' => 'Lion Kingdom',
                    'description' => 'Tiket masuk untuk melihat kerajaan singa',
                    'expiredDate' => '2023-06-05'
                ],
                [
                    'ticketId' => 'TICK009',
                    'price' => 14,
                    'title' => 'Snake House',
                    'description' => 'Tiket masuk ke rumah ular',
                    'expiredDate' => '2023-05-31'
                ],
                [
                    'ticketId' => 'TICK010',
                    'price' => 22,
                    'title' => 'Tropical Rainforest',
                    'description' => 'Tiket masuk ke hutan hujan tropis',
                    'expiredDate' => '2023-06-07'
                ]
            ];

    }

    public function addTicket($ticket)
    {

        $this->tickets[] = $ticket;
        return $this->findTicket($ticket['id']);

    }

    public function removeTicket($ticket)
    {
        
        $index = array_search($ticket, $this->tickets);
        if ($index !== false) {

            array_splice($this->tickets, $index, 1);
            return true;

        } else {

            return false;

        }

    }

    public function getTickets()
    {
        return $this->tickets;
    }

    public function countTickets()
    {

        return count($this->tickets);

    }

    public function findTicket($id)
    {
        foreach ($this->tickets as $ticket) {

            if ($ticket['id'] === $id) {
                return $ticket;
            }

        }
        return null;
    }

    public function updateTicket($id, $newData)
    {
        
        foreach ($this->tickets as &$ticket) {

            if ($ticket['ticketId'] === $id) {

                $ticket['price'] = $newData['price'];
                $ticket['title'] = $newData['title'];
                $ticket['description'] = $newData['description'];
                $ticket['expiredDate'] = $newData['expiredDate'];

                $this->tickets[] = $ticket;
                return $this->findTicket($id);

            }

        }

        return false;

    }

    public function getTicketsHandler()
    {

        $result = new Result();

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->tickets;

        return $result->toJson();

    }

    public function addTicketHandler($data)
    {

        $result = new Result();

        if ($data && isset($data['id'])) {

            $ticket = [
                'ticketId' => mt_rand(1, 9999999999),
                'price' => $data['price'],
                'title' => $data['title'],
                'description' => $data['description'],
                'expiredDate' => $data['expiredDate'],
            ];

            $resData = $this->addTicket($ticket);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();

    }

    public function updateTicketHandler($data)
    {

        $result = new Result();
        
        if ($data && isset($data['id'])) {

            $id = $data['id'];

            $ticket = [
                'ticketId' => mt_rand(1, 9999999999),
                'price' => $data['price'],
                'title' => $data['title'],
                'description' => $data['description'],
                'expiredDate' => $data['expiredDate'],
            ];

            $resData = $this->updateTicket($id, $ticket);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }

        } else {

            $result->code = CODE_SUCCESS;
            $result->message = MESSAGE_INVALID_DATA;
            $result->data = null;

        }

        return $result->toJson();

    }

    public function removeTicketHandler($id)
    {

        $result = new Result();
        
        $ticket = $this->findTicket($id);
        if ($ticket) {

            if ($this->removeTicket($ticket)) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = null;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = null;

            }
            

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;
            $result->data = null;

        }

        return $result->toJson();

    }

}

class TransactionManager
{
    private $transactions;

    public function __construct()
    {
        $this->transactions = [
                [
                    'id' => 1,
                    'date' => '2023-05-20',
                    'amount' => 100.0,
                    'description' => 'Pembelian tiket kebun binatang A',
                    'visitorId' => 1,
                    'ticketId' => 'TICK001',
                    'ticketQuantity' => 2
                ],
                [
                    'id' => 2,
                    'date' => '2023-05-21',
                    'amount' => 50.0,
                    'description' => 'Pembelian tiket kebun binatang B',
                    'visitorId' => 2,
                    'ticketId' => 'TICK002',
                    'ticketQuantity' => 1
                ],
                [
                    'id' => 3,
                    'date' => '2023-05-22',
                    'amount' => 200.0,
                    'description' => 'Pembelian tiket kebun binatang C',
                    'visitorId' => 3,
                    'ticketId' => 'TICK001',
                    'ticketQuantity' => 4
                ],
                [
                    'id' => 4,
                    'date' => '2023-05-23',
                    'amount' => 75.0,
                    'description' => 'Pembelian tiket kebun binatang D',
                    'visitorId' => 4,
                    'ticketId' => 'TICK002',
                    'ticketQuantity' => 3
                ],
                [
                    'id' => 5,
                    'date' => '2023-05-24',
                    'amount' => 120.0,
                    'description' => 'Pembelian tiket kebun binatang E',
                    'visitorId' => 5,
                    'ticketId' => 'TICK001',
                    'ticketQuantity' => 2
                ],
                [
                    'id' => 6,
                    'date' => '2023-05-25',
                    'amount' => 90.0,
                    'description' => 'Pembelian tiket kebun binatang F',
                    'visitorId' => 6,
                    'ticketId' => 'TICK001',
                    'ticketQuantity' => 3
                ],
                [
                    'id' => 7,
                    'date' => '2023-05-26',
                    'amount' => 180.0,
                    'description' => 'Pembelian tiket kebun binatang G',
                    'visitorId' => 7,
                    'ticketId' => 'TICK002',
                    'ticketQuantity' => 1
                ]
            ];

    }

    public function addTransaction($transaction)
    {

        $this->transactions[] = $transaction;
        return $this->findTransaction($transaction['id']);

    }

    public function removeTransaction($transaction)
    {
        
        $index = array_search($transaction, $this->transactions);
        if ($index !== false) {

            array_splice($this->transactions, $index, 1);
            return true;

        } else {

            return false;

        }

    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function countTransactions()
    {

        return count($this->transactions);

    }

    public function findTransaction($id)
    {
        foreach ($this->transactions as $transaction) {

            if ($transaction['id'] === $id) {

                return $transaction;

            }

        }
        return null;
    }

    public function updateTransaction($id, $newData)
    {
        
        foreach ($this->transactions as &$transaction) {
            if ($transaction['id'] === $id) {

                $transaction['date'] = $newData['date'];
                $transaction['amount'] = $newData['amount'];
                $transaction['description'] = $newData['description'];
                $transaction['visitorId'] = $newData['visitorId'];
                $transaction['status'] = $newData['status'];
                $transaction['category'] = $newData['category'];

                $this->transactions[] = $transaction;

                return $this->findTransaction($id);
            }
        }

        return false;

    }

    public function calculateAmount($filter, $value)
    {

        $result = new Result();
        $utils = new Utils();
        
        $totalAmount = 0;

        switch ($filter) {
            case 'date':
                foreach ($this->transactions as $transaction) {
                    if ($transaction['date'] == $value) {
                        $totalAmount += $transaction['amount'];
                    }
                }
                break;

            case 'ticketType':
                foreach ($this->transactions as $transaction) {
                    if ($transaction['ticketType'] == $value) {
                        $totalAmount += $transaction['amount'];
                    }
                }
                break;

            default:
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_INVALID_DATA;
        }

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = [
            'total_amount' => $totalAmount,
            'amount_rupiah' => $utils->makeItRupiah($totalAmount),
            'amount_sentence' => $utils->convertPriceToWords($totalAmount),
        ];

        return $result->toJson();
    }

    public function countTicketsByMonth($month)
    {

        $ticket = new TicketManager;
        $ticketsByMonth = 0;

        $transactions = $this->transactions;
    
        foreach ($transactions as $transaction) {
            $date = $transaction['date'];
            $transactionMonth = date('Y-m', strtotime($date));

            if ($transactionMonth == $month) {

                $ticketAmount = $ticket->findTicket($transaction['ticketId']);
                
                $ticketsByMonth += $ticketAmount;

            }

        }
    
        return $ticketsByMonth;
    }

    public function getTransactionsHandler()
    {

        $result = new Result();
        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->transactions;
        return $result->toJson();

    }

    public function addTransactionHandler($data)
    {

        $result = new Result();

        if ($data && isset($data['id'])) {

            $transaction = [
                'id' => mt_rand(1, 9999999999),
                'date' => $data['date'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'visitorId' => $data['visitorId'],
                'status' => $data['status'],
                'category' => $data['category'],
            ];

            $resData = $this->addTransaction($transaction);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }

        return $result->toJson();

    }

    public function updateTransactionHandler($data)
    {

        $result = new Result();
        
        if ($data && isset($data['id'])) {

            $id = $data['id'];
            $transaction = [
                'id' => mt_rand(1, 9999999999),
                'date' => $data['date'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'visitorId' => $data['visitorId'],
                'status' => $data['status'],
                'category' => $data['category'],
            ];

            $resData = $this->updateTransaction($id, $transaction);

            if ($resData) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = $resData;

            } else {
                
                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $resData;

            }

        } else {

            $result->code = CODE_SUCCESS;
            $result->message = MESSAGE_INVALID_DATA;
            $result->data = null;

        }

        return $result->toJson();

    }

    public function removeTransactionHandler($id)
    {

        $result = new Result();
        
        $transaction = $this->findTransaction($id);
        if ($transaction) {

            if ($this->removeTransaction($transaction)) {

                $result->code = CODE_SUCCESS;
                $result->message = MESSAGE_SUCCESS;
                $result->data = null;

            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = null;

            }
            

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;
            $result->data = null;

        }

        return $result->toJson();

    }

    public function getDetailTransactionHandler($id)
    {

        $result = new Result();
        $ticket = new TicketManager();
        $visitor = new VisitorManager();

        $transaction = $this->findTransaction($id);

        if (!empty($id)) {

            if ($transaction) {

                $transaction['ticket'] = $ticket->findTicket($transaction['ticketId']);
                $transaction['visitor'] = $visitor->findVisitor($transaction['visitorId']);
    
            } else {

                $result->code = CODE_FAILED;
                $result->message = MESSAGE_FAILED;
                $result->data = $transaction;

            }

        } else {

            $result->code = CODE_FAILED;
            $result->message = MESSAGE_INVALID_DATA;

        }
        
        
        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->transactions;

        return $result->toJson();

    }

    public function getIncomeHandler($filter, $value)
    {

        $result = new Result();

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->calculateAmount($filter, $value);

        return $result->toJson();
    }

    public function getTicketsByMonthHandler($month)
    {

        $result = new Result();

        $result->code = CODE_SUCCESS;
        $result->message = MESSAGE_SUCCESS;
        $result->data = $this->countTicketsByMonth($month);

        return $result->toJson();
    }

}

class Router
{
    private $routes = [
        [
            'method' => 'GET',
            'path' => '/zookeeper/list',
            'classHandler' => 'ZooKeeperManager',
            'functionHandler' => 'getZooKeepersHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/zookeeper/add',
            'classHandler' => 'ZooKeeperManager',
            'functionHandler' => 'addZooKeeperHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/zookeeper/update',
            'classHandler' => 'ZooKeeperManager',
            'functionHandler' => 'updateZooKeeperHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/zookeeper/remove',
            'classHandler' => 'ZooKeeperManager',
            'functionHandler' => 'removeZooKeeperHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/animal/list',
            'classHandler' => 'AnimalManager',
            'functionHandler' => 'getAnimalsHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/animal/add',
            'classHandler' => 'AnimalManager',
            'functionHandler' => 'addAnimalHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/animal/update',
            'classHandler' => 'AnimalManager',
            'functionHandler' => 'updateAnimalHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/animal/remove',
            'classHandler' => 'AnimalManager',
            'functionHandler' => 'removeAnimalHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/cage/list',
            'classHandler' => 'CageManager',
            'functionHandler' => 'getCageHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/cage/add',
            'classHandler' => 'CageManager',
            'functionHandler' => 'addCageHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/cage/update',
            'classHandler' => 'CageManager',
            'functionHandler' => 'updateCageHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/cage/remove',
            'classHandler' => 'CageManager',
            'functionHandler' => 'removeCageHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/visitor/list',
            'classHandler' => 'VisitorManager',
            'functionHandler' => 'getVisitorHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/visitor/add',
            'classHandler' => 'VisitorManager',
            'functionHandler' => 'addVisitorHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/visitor/update',
            'classHandler' => 'AnimalManager',
            'functionHandler' => 'updateAnimalHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/visitor/remove',
            'classHandler' => 'VisitorManager',
            'functionHandler' => 'removeVisitorHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/visitor/getAvgAge',
            'classHandler' => 'AnimalManager',
            'functionHandler' => 'removeAnimalHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/ticket/list',
            'classHandler' => 'TicketManager',
            'functionHandler' => 'getTicketHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/ticket/add',
            'classHandler' => 'TicketManager',
            'functionHandler' => 'addTicketHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/ticket/update',
            'classHandler' => 'TicketManager',
            'functionHandler' => 'updateTicketHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/ticket/remove',
            'classHandler' => 'TicketManager',
            'functionHandler' => 'removeTicketHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/transaction/list',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'getTransactionHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/transaction/add',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'addTransactionHandler',
        ],
        [
            'method' => 'POST',
            'path' => '/transaction/update',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'updateTransactionHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/transaction/remove',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'removeTransactionHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/transaction/detail',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'getDetailTransactionHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/transaction/getIncome',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'getIncomeHandler',
        ],
        [
            'method' => 'GET',
            'path' => '/transaction/getTicketsByMonth',
            'classHandler' => 'TransactionManager',
            'functionHandler' => 'getTicketsByMonthHandler',
        ],
    ];

    public function handleRequest($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {

                if ($method == 'POST') {
                    $data = $_POST;
                } elseif ($method == 'GET') {
                    $data = $_GET;
                }
                
                $class = $route['classHandler'];
                $function = $route['functionHandler'];
                $classInstance = new $class();
                $classInstance->$function($data);
                return;
            }
        }

        
        $this->notFoundHandler();
    }

    private function matchPath($routePath, $requestPath)
    {
        $routePath = trim($routePath, '/');
        $requestPath = trim($requestPath, '/');

        $routeSegments = explode('/', $routePath);
        $requestSegments = explode('/', $requestPath);

        if (count($routeSegments) !== count($requestSegments)) {
            return false;
        }

        for ($i = 0; $i < count($routeSegments); $i++) {
            $routeSegment = $routeSegments[$i];
            $requestSegment = $requestSegments[$i];

            if ($routeSegment !== $requestSegment && strpos($routeSegment, ':') === false) {
                return false;
            }
        }

        return true;
    }

    private function notFoundHandler()
    {

        $result = new Result();
        $result->code = CODE_NOT_FOUND;
        $result->message = MESSAGE_ENDPOINT_NOTFOUND;

    }
}

$router = new Router();
$router->handleRequest(
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI']
);
