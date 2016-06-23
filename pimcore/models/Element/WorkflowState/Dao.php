<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @category   Pimcore
 * @package    Element
 * @copyright  Copyright (c) 2009-2016 pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Model\Element\WorkflowState;

use Pimcore\Model;
use Pimcore\Model\Document;
use Pimcore\Model\Asset;
use Pimcore\Model\Object;

class Dao extends Model\Dao\AbstractDao
{

    /**
     * @param $cid
     * @param $ctype
     * @throws \Exception
     */
    public function getByIdAndType($cid, $ctype)
    {
        $data = $this->db->fetchRow("SELECT * FROM element_workflow_state WHERE cid = ? AND ctype = ?", [$cid, $ctype]);

        if (!$data["cid"]) {
            throw new \Exception("WorkflowStatus item with cid " . $cid . " and ctype " . $ctype . " not found");
        }
        $this->assignVariablesToModel($data);
    }

    /**
     * Save object to database
     *
     * @return void
     */
    public function save()
    {
        $dataAttributes = get_object_vars($this->model);

        $data = [];
        foreach ($dataAttributes as $key => $value) {
            if (in_array($key, $this->getValidTableColumns("element_workflow_state"))) {
                $data[$key] = $value;
            }
        }

        $this->db->insertOrUpdate("element_workflow_state", $data);

        return true;
    }

    /**
     * Deletes object from database
     *
     * @return void
     */
    public function delete()
    {
        $this->db->delete("element_workflow_state", $this->db->quoteInto("cid = ?", $this->model->getCid()) . " AND " . $this->db->quoteInto("ctype = ?", $this->model->getCtype()));
    }

}
