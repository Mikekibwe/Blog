<?php 
namespace App\Table;
use \PDO;
use App\Table\Exception\NotFoundException;
use App\Model\Post;
abstract class Table
{
    protected $pdo;
    protected $table = null;
    protected $class = null;
    public function __construct(PDO $pdo)
    {
        if ($this->table === null) {
            throw new \Exception("La classe " . get_class($this) . " n'a pas de propriete \$table");
        }
        if ($this->class === null) {
            throw new \Exception("La classe " . get_class($this) . " n'a pas de propriete \$class");
        }
        $this->pdo = $pdo;
    }
    public function find (int $id)
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if ($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }    
    /**
     * Vérifie si une valeur existe dans la table
     *
     * @param  string $field champ à rechercher
     * @param  mixed $value Valeur associée au champs
     * @return bool
     */
    public function exists (string $field, $value, ?int $except = null): bool 
    {
        $sql = "SELECT COUNT(id) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }
}