<?php

	// A guy Started A ship Company
	// People or stuffs like lauggage for Import Export are the source of income from his ship
	// He use to buy the fuel to run his ship so his expenses is the cost of fuel.
	// He wants to earn money by offering the transport service
	// He wants to chage Rs 100 For A guy (Matured) and Rs 25 For Infant. Any People form above age 14 is adult
	// So He wants to make a system to calculate the profit
	
	class Ship
	{
		public $items;
		
		public $fuel;

		public function __construct(Fuel $fuel)
		{
			$this->fuel = $fuel;
		}

		public function addItem(ChargingInterface $item)
		{
			$this->items[] = $item;
		}
	}

	// Fule May Be Different Type So All Type Needs to have This 

	Class Fuel
	{
		public $charge; //per litere

		public $tank;

		public function __construct($total, $charge)
		{
			$this->tank = new Tank($total);

			$this->chagre = $charge;

		}

		public function calculateCost()
		{
			return $this->tank->usedFuel() * $this->charge; //in future adding tax will not make any problem or we can add complex charging
		}
	}

//Tank
	class Tank
	{
		public $remaining;

		public $totalFuel;

		public function __construct($totalFuel)
		{
			$this->totalFuel = $totalFuel;

			$this->remaining = $totalFuel;
		}

		public function fuelDecreasing()
		{
			$this->remaining = $this->remaining - 3;
			echo 'Remaining Fuel : ' . $this->remaining . PHP_EOL;
		}

		public function usedFuel()
		{
			return $this->totalFuel - $this->remaining;
		}


	}

	//income source
	
	interface ChargingInterface
	{
		public function charge();
	}

	//human
	class Human implements ChargingInterface
	{
		private $dob;

		public $name;

		public function __construct( $name, $dob )
		{
			$this->dob = $dob;

			$this->name = $name;
		}

		public function getAge()
		{
			$dob = new DateTime($this->dob);

			return $dob->diff( new DateTime( date('Y-m-d') ) )->y;
		}

		public function charge()
		{
			echo $this->name .'s age: ' .$this->getAge() . PHP_EOL;
			return ( $this->getAge() <= 14 ) ? 25 : 100;

		}
	}

	//Item (Lauggage)
	class Item implements ChargingInterface
	{
		public $consumerName;

		private $weight;
		
		public function __construct($consumerName,$weight)
		{
			$this->consumerName = $consumerName;

			$this->weight = $weight;
		}

		public function getWeight()
		{
			return $this->weight;
		}

		public function charge()
		{
			return $this->weight * 20;
		}
	}


	//Business Logic....
	
	class BusinessCalculator
	{
		public function __construct(Ship $ship)
		{
			$this->ship = $ship;
		}

		public function calculateProfit()
		{
			$income = 0;

			foreach($this->ship->items as $shipItem)
			{
				$income += $shipItem->charge();
			}

			return $income - $this->ship->fuel->calculateCost();
		}
	}

	//Controller 
					
	$bazajOil = new Fuel( 20, 70 );

	$ship = new Ship( $bazajOil );

	$bazajOil->tank->fuelDecreasing();
								
	$ship->addItem( new Human( 'Ram Sharma','2006-02-02' ) );

	$bazajOil->tank->fuelDecreasing();
							
	$ship->addItem( new Item('Hari Traders', 7 ) );

	$bazajOil->tank->fuelDecreasing();

	$ship->addItem( new Human( 'Ram Sharma','2006-02-02' ) );
	
	$bazajOil->tank->fuelDecreasing();
	
	$businessCalculate = new BusinessCalculator($ship);
	
	echo $businessCalculate->calculateProfit();