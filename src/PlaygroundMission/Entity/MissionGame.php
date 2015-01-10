<?php
namespace PlaygroundMission\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Entity @HasLifecycleCallbacks
 * @ORM\Table(name="game_mission_game")
 */
class MissionGame
{

    protected $inputFilter;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\ManyToOne(targetEntity="Game")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id", onDelete="CASCADE")
     **/
    protected $game;

    /**
     * @ORM\ManyToOne(targetEntity="Mission", inversedBy="missionGames")
     *
     **/
    protected $mission;
    
    /**
     * @ORM\OneToMany(targetEntity="MissionGameCondition", mappedBy="missionGame", cascade={"persist","remove"})
     */
    protected $conditions;

    /**
     * position
     * @ORM\Column(name="position", type="integer", nullable=false)
     */
    protected $position; 

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->conditions = new ArrayCollection();
    }

    /** @PrePersist */
    public function createChrono()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /** @PreUpdate */
    public function updateChrono()
    {
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * @param $id
     * @return MissionGame
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

     /**
     * @param $id
     * @return MissionGame
     */
    public function setPosition($position)
    {
        $this->position = (int) $position;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return the $game
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param field_type $game
     */
    public function setGame($game)
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return \PlaygroundGame\Service\Mission $game
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @param \PlaygroundGame\Service\Mission $mission
     */
    public function setMission($mission)
    {
        $this->mission = $mission;

        return $this;
    }
  
    /**
     * @return the $conditions
     */
    public function getConditions()
    {
        return $this->conditions;
    }

	/**
     * @param field_type $conditions
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        
        return $this;
    }
    
    public function addConditions(ArrayCollection $conditions)
    {
        foreach ($conditions as $condition) {
            $condition->setMissionGame($this);
            $this->conditions->add($condition);
        }
    }
    
    public function removeConditions(ArrayCollection $conditions)
    {
        foreach ($conditions as $condition) {
            $this->conditions->removeElement($condition);
        }
    }
    
    /**
     * Add a condition to the mission game.
     *
     * @param MisionGameCondition $condition
     *
     * @return void
     */
    public function addCondition($condition)
    {
        $this->conditions[] = $condition;
    }

	/**
     *
     * @return \DateTime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     *
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        
        return $this;
    }

    /**
     *
     * @return \DateTime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     *
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        
        return $this;
    }

    public function getInputFilter ()
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $this->inputFilter = $inputFilter;
        }
    
        return $this->inputFilter;
    }
}