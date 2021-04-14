<?php
/**
 * +------------------------------------------------------------------------------
 * �ļ����ƣ� core/FileFS.class.php.
 * +------------------------------------------------------------------------------
 * �ļ������� LocalFS �ļ�ϵͳ
 * +------------------------------------------------------------------------------
 */
class WF_FileFS
{
    // ������Ϣ
    private $error = '';

    /**
     * �ܹ�����.
     */
    public function __construct()
    {
    }

    /**
     * get_gpath��ȡ��/��ͷ������·����GB2312 ���ڷ����ļ�ϵͳ
     * get_upath��ȡ��/��ͷ������·����UTF-8  ����ҳ�����.
     *
     * @param unknown_type $path
     * @param unknown_type $type
     *
     * @return unknown
     */
    public function get_gpath($path, $type = 'u')
    {
        if ('r' == $type) {
            $path = str_replace('//', '/', WF_REAL_ROOT_PATH . $path);
        }
        if ('u' == $type) {
            $path = str_replace('//', '/', WF_REAL_USER_PATH . $path);
        }
        $path = WF_SYS_WIN ? wf_u2g($path) : $path;

        return $path;
    }

    /**
     * ���ظ���Ŀ¼���ļ� �б��굥.
     *
     * @param unknown_type $path
     * @param unknown_type $deep
     *
     * @return unknown
     */
    public function nlist($path, &$list = [], &$path2 = '')
    {
        $list = ['dirs' => [], 'files' => []];

        $path2 = $this->get_gpath($path);
        if (!is_dir($path2)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼������';

            return false;
        } elseif (!is_readable($path2)) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ��';

            return false;
        }

        $tlist = glob($path2 . '{,.}*', GLOB_MARK | GLOB_BRACE) or [];
        foreach ($tlist as $file2) {
            if ('.' == basename($file2) || '..' == basename($file2)) {
                continue;
            }
            $file = str_replace('\\', '/', $file2);
            $file = $this->get_upath($file);
            $stat = stat($file2);
            if (!$stat) {
                $stat = ['size' => 0, 'atime' => 0, 'ctime' => 0, 'mtime' => 0];
            }

            $stat['name'] = get_basename($file);
            $stat['path'] = $path . $stat['name'];
            $stat['fsize'] = get_deal_size($stat['size']);
            $stat['chmod'] = get_deal_chmod($file2, false);
            $stat['fchmod'] = get_deal_chmod($file2, true);
            $stat['fatime'] = date('Y-m-d H:i:s', $stat['atime']);
            $stat['fctime'] = date('Y-m-d H:i:s', $stat['ctime']);
            $stat['fmtime'] = date('Y-m-d H:i:s', $stat['mtime']);

            if ('/' == mb_substr($file, -1, 1)) {
                $stat['path'] .= '/';
                $stat['type'] = 'dir';
                $stat['ext'] = '_dir';
            } else {
                $stat['type'] = 'file';
                $stat['ext'] = get_fileext($file);
            }
            $list["{$stat['type']}s"][] = $stat;
        }

        unset($tlist, $stat, $path, $file, $file2); //$path2,

        return true;
    }

    /**
     * ������ �ļ��С��ļ�.
     *
     * @param unknown_type $oldname
     * @param unknown_type $newname
     *
     * @return unknown
     */
    public function rename($oldname, $newname)
    {
        $oldname = $this->get_gpath($oldname);
        $newname = $this->get_gpath($newname);

        if (!file_exists($oldname)) {
            $this->error = '�ļ�ϵͳ����ԭʼ�ļ�������';
        } elseif (file_exists($newname)) {
            $this->error = '�ļ�ϵͳ�����Ѵ���ͬ���ļ�';
        } elseif (!is_writeable(get_dirname($oldname))) {
            $this->error = '�ļ�ϵͳ����û���޸�Ȩ��';
        } elseif (!rename($oldname, $newname)) {
            $this->error = '�ļ�ϵͳ����������ʧ��';
        } else {
            $this->error = '';
        }

        return empty($this->error);
    }

    /**
     * �½� �ļ���.
     *
     * @param unknown_type $path
     * @param unknown_type $mode
     *
     * @return unknown
     */
    public function mkdir($path, $mode = 0755)
    {
        $path = $this->get_gpath($path);
        if (file_exists($path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼�Ѵ��ڣ�';
        } elseif (!is_writeable(get_dirname($path))) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ��';
        } elseif (!mkdir($path, $mode)) {
            $this->error = '�ļ�ϵͳ�����½�ʧ��';
        } else {
            $this->error = '';
        }

        return empty($this->error);
    }

    /**
     * �½� �ļ�.
     *
     * @param unknown_type $path
     * @param unknown_type $content
     *
     * @return unknown
     */
    public function mkfile($path, $content = ' ')
    {
        $path = $this->get_gpath($path);
        if (file_exists($path)) {
            $this->error = '�ļ�ϵͳ�����ļ��Ѵ��ڣ�';
        } elseif (!is_writeable(get_dirname($path))) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ�ޣ�';
        } elseif (!file_put_contents($path, $content)) {
            $this->error = '�ļ�ϵͳ�����ļ�д��ʧ��';
        } else {
            $this->error = '';
        }

        return empty($this->error);
    }

    public function rmdir($path, $deep = false, &$info = [])
    {
        $path = $this->get_gpath($path);
        $info['de'] = $info['ds'] = $info['fe'] = $info['fs'] = $info['si'] = 0;
        $info['el'] = [];

        if (!is_dir($path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼������';

            return false;
        } elseif (!is_writeable($path)) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ��';

            return false;
        }

        $list = $this->get_golblist($path, -1);
        $list = array_reverse($list);
        foreach ($list as $val) {
            if ('/' == mb_substr($val, -1, 1)) {
                if (is_writeable($val) && rmdir($val)) {
                    ++$info['ds'];
                } else {
                    ++$info['de'];
                    $info['el'][] = $this->get_upath($val);
                }
            } else {
                $size = filesize($val) or 0;
                if (is_writeable($val) && unlink($val)) {
                    ++$info['fs'];
                    $info['si'] += $size;
                } else {
                    ++$info['fe'];
                    $info['el'][] = $this->get_upath($val);
                }
            }
        }

        $info['si'] = get_deal_size($info['si']);
        if (!$info['el'] && rmdir($path)) {
            ++$info['ds'];
        } else {
            ++$info['de'];
            $info['el'][] = $this->get_upath($path);
        }

        $info['el'] = array_reverse($info['el']);

        return true;
    }

    /**
     * �ļ�ɾ��.
     *
     * @param unknown_type $type
     * @param unknown_type $objs
     * @param unknown_type $info
     *
     * @return unknown
     */
    public function rmfile($path, $deep = false, &$info = [])
    {
        $path = $this->get_gpath($path);
        if (!is_file($path)) {
            $this->error = '�ļ�ϵͳ�����ļ�������';
        } elseif (!is_writeable($path)) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ��';

            return false;
        } elseif (!unlink($path)) {
            $this->error = '�ļ�ϵͳ�����ļ�ɾ��ʧ��';
        } else {
            $this->error = '';
        }

        return empty($this->error);
    }

    public function rmall($paths, $deep = false, &$info = [])
    {
        $info['de'] = $info['ds'] = $info['fe'] = $info['fs'] = $info['si'] = 0;
        $info['el'] = [];

        foreach ($paths as $path) {
            $path = $this->get_gpath($path);

            // ɾ���ļ�
            if (is_file($path)) {
                $info['si'] += filesize($path);
                if (is_writeable($path) && unlink($path)) {
                    ++$info['fs'];
                } else {
                    $info['el'][] = $this->get_upath($path);
                }
                continue;
            }

            // ɾ���ļ���
            $list = $this->get_golblist($path, -1);
            $list = array_reverse($list);
            foreach ($list as $val) {
                if ('/' == mb_substr($val, -1, 1)) {
                    if (is_writeable($val) && rmdir($val)) {
                        ++$info['ds'];
                    } else {
                        ++$info['de'];
                        $info['el'][] = $this->get_upath($val);
                    }
                } else {
                    $size = filesize($val);
                    if (is_writeable($val) && unlink($val)) {
                        ++$info['fs'];
                        $info['si'] += $size;
                    } else {
                        ++$info['fe'];
                        $info['el'][] = $this->get_upath($val);
                    }
                }
            }

            if (is_writeable($path) && rmdir($path)) {
                ++$info['ds'];
            } else {
                ++$info['de'];
                $info['el'][] = $this->get_upath($path);
            }
        }

        $info['si'] = get_deal_size($info['si']);
        $info['el'] = array_reverse($info['el']);

        return true;
    }

    /**
     * ����Ŀ¼���ļ�.
     *
     * @param string $path
     * @param array  $list
     * @param bool   $force
     * @param array  $info
     *
     * @return bool
     */
    public function cut($path, $list = [], $force = false, &$info = [])
    {
        $path2 = $this->get_gpath($path);
        if (!is_writeable($path2)) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ��';

            return false;
        }

        $info['success'] = $info['errors'] = 0;
        $info['exists'] = $info['permission'] = [];
        foreach ($list as $file) {
            $from = $this->get_gpath($file);
            $to = $this->get_gpath($path . get_basename($file));
            if (file_exists($to)) {
                ++$info['errors'];
                $info['exists'][] = $file;
            } elseif (!is_writeable($from)) {
                ++$info['errors'];
                $info['permission'][] = $file;
            } elseif (!rename($from, $to)) {
                ++$info['errors'];
            } else {
                ++$info['success'];
            }
        }

        return true;
    }

    /**
     * ����Ŀ¼���ļ�.
     *
     * @param string $path
     * @param array  $list
     * @param bool   $force
     * @param array  $info
     *
     * @return bool
     */
    public function copy($path, $list = [], $force = false, &$info = [])
    {
        $path2 = $this->get_gpath($path);
        if (!is_writeable($path2)) {
            $this->error = '�ļ�ϵͳ����û�з���Ȩ��';

            return false;
        }

        $info['success'] = $info['errors'] = $info['dnumber'] = $info['fnumber'] = $info['size'] = 0;
        $info['exists'] = $info['permission'] = $info['list'] = [];
        foreach ($list as $val) {
            $from = $this->get_gpath($val);
            if (!is_readable($from)) {
                ++$info['errors'];
                $info['permission'][] = $val;
            } elseif (is_dir($from)) {
                $to = $this->get_gpath($path . get_basename($val));
                if (file_exists($to)) {
                    ++$info['errors'];
                    $info['exists'][] = $val;
                    continue;
                } elseif (!mkdir($to, 0755, true)) {
                    ++$info['errors'];
                    $info['permission'][] = $this->get_upath($to);
                } else {
                    ++$info['success'];
                    ++$info['dnumber'];
                }

                $files = $this->get_golblist($from, -1);
                $strpos = mb_strlen(get_dirname($from)) + 1;
                foreach ($files as $v) {
                    $to = $path2 . mb_substr($v, $strpos);
                    if ('/' == mb_substr($to, -1)) {
                        if (!mkdir($to, 0755, true)) {
                            ++$info['errors'];
                            $info['permission'][] = $this->get_upath($to);
                        } else {
                            ++$info['success'];
                            ++$info['dnumber'];
                        }
                    } else {
                        if (file_exists($to)) {
                            ++$info['errors'];
                            $info['exists'][] = $this->get_upath($v);
                        } elseif (!copy($v, $to)) {
                            ++$info['errors'];
                            $info['permission'][] = $this->get_upath($v);
                        } else {
                            $info['size'] += filesize($to);
                            ++$info['success'];
                            ++$info['fnumber'];
                        }
                    }
                }
            } elseif (is_file($from)) {
                $to = $this->get_gpath($path . get_basename($val));
                if (file_exists($to)) {
                    ++$info['errors'];
                    $info['exists'][] = $val;
                } elseif (!copy($from, $to)) {
                    ++$info['errors'];
                    $info['permission'][] = $val;
                } else {
                    $info['size'] = filesize($to);
                    ++$info['success'];
                    ++$info['fnumber'];
                }
            }
        }

        $info['size'] = get_deal_size($info['size']);

        return true;
    }

    /**
     * �����ļ�Ȩ��.
     *
     * @param string $path
     * @param int    $chmod
     * @param bool   $deep
     * @param array  $info
     *
     * @return bool
     */
    public function chmod($path, $chmod = 0755, $deep = false, &$info = [])
    {
        $path2 = $this->get_gpath($path);
        $info['dn'] = $info['fn'] = $info['en'] = 0;
        $info['el'] = [];

        if (is_file($path2) || (!$deep && is_dir($path2))) {
            if (!chmod($path2, $chmod)) {
                ++$info['en'];
            } else {
                ++$info['fn'];
            }

            return $info['fn'];
        } elseif ($deep && is_dir($path2)) {
            if (!chmod($path2, $chmod)) {
                ++$info['en'];
                $info['el'][] = $path;
            } else {
                ++$info['dn'];
            }
            $list = $this->get_golblist($path2, -1);
            foreach ($list as $val) {
                if (!chmod($val, $chmod)) {
                    ++$info['en'];
                    $info['el'][] = $this->get_upath($val);
                } else {
                    if ('/' == mb_substr($val, -1)) {
                        ++$info['dn'];
                    } else {
                        ++$info['fn'];
                    }
                }
            }
        } else {
            return false;
        }

        return true;
    }

    /**
     * �ļ��С��ļ�ѹ��.
     *
     * @param unknown_type $path
     * @param unknown_type $name
     * @param unknown_type $info
     *
     * @return unknown
     */
    public function zip($path, $name, &$info = [])
    {
        $path = $this->get_gpath($path, 'u');
        $name = $this->get_gpath($name, 'x');

        if (!is_dir($path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼������';

            return false;
        } elseif (!is_writeable(get_dirname($path))) {
            $this->error = '�ļ�ϵͳ���󣬵�ǰĿ¼û��д��Ȩ��';

            return false;
        } elseif (!is_readable($path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼�ļ�û�з���Ȩ��';

            return false;
        }

        $ifix = 0;
        $name = get_dirname($path) . '/' . $name;
        $file = $name . '.zip';
        while (file_exists($file) && 6 > $ifix++) {
            if (5 < $ifix) {
                $ifix = time();
            }
            $file = "{$name}_X{$ifix}.zip";
        }

        require WF_CORE_ROOT . 'PclZip.class.php';
        $Zip = new WF_PclZip($file);
        if (!$Zip->create($path, PCLZIP_OPT_REMOVE_PATH, $path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼�鵵����</br>Error : ' . $Zip->errorInfo(true);

            return false;
        }

        $info['dn'] = $info['fn'] = $info['si'] = $info['sc'] = 0;
        $list = $Zip->listContent() or [];
        foreach ($list as $val) {
            if ($val['folder']) {
                ++$info['dn'];
            } else {
                $info['sc'] += $val['compressed_size'];
                $info['si'] += $val['size'];
                ++$info['fn'];
            }
        }

        $info['name'] = $this->get_upath(get_basename($file), 'x');
        $info['si'] = get_deal_size($info['si']);
        $info['sc'] = get_deal_size($info['sc']);

        return true;
    }

    /**
     * �ļ���ѹ.
     *
     * @param unknown_type $path
     * @param unknown_type $name
     * @param unknown_type $info
     *
     * @return unknown
     */
    public function unzip($path, $name, &$info = [])
    {
        $path = $this->get_gpath($path, 'u');
        $name = $this->get_gpath($name, 'x');

        if (false == mb_stripos($name, '.zip') || !is_file($path)) {
            $this->error = '�ļ�ϵͳ����ѹ���ļ�������';

            return false;
        } elseif (!is_writeable(get_dirname($path))) {
            $this->error = '�ļ�ϵͳ���󣬵�ǰĿ¼û��д��Ȩ��';

            return false;
        } elseif (!is_readable($path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼�ļ�û�з���Ȩ��';

            return false;
        }

        $ifix = 0;
        $name = get_dirname($path) . '/' . mb_substr(get_basename($name), 0, -4);
        $file = $name . '/';
        while (file_exists($file) && 6 > $ifix++) {
            if (5 < $ifix) {
                $ifix = time();
            }
            $file = "{$name}_X{$ifix}/";
        }

        require WF_CORE_ROOT . 'PclZip.class.php';
        $Zip = new WF_PclZip($path);

        if (!$Zip->extract($file, false)) {
            $this->error = '�ļ�ϵͳ�����ļ���ѹʧ��</br>Error : ' . $Zip->errorInfo(true);

            return false;
        }

        $info['dn'] = $info['fn'] = $info['si'] = $info['sc'] = 0;
        $list = $Zip->listContent() or [];
        foreach ($list as $val) {
            if ($val['folder']) {
                ++$info['dn'];
            } else {
                $info['sc'] += $val['compressed_size'];
                $info['si'] += $val['size'];
                ++$info['fn'];
            }
        }

        $info['name'] = $this->get_upath(get_basename($file), 'x');
        $info['si'] = get_deal_size($info['si']);
        $info['sc'] = get_deal_size($info['sc']);

        return true;
    }

    /**
     * �ļ��ϴ�.
     */
    public function upload($path, $name, $cover = false)
    {

        // HTTP headers for no cache etc
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');

        // Look for the content type header
        if (isset($_SERVER['HTTP_CONTENT_TYPE'])) {
            $contentType = $_SERVER['HTTP_CONTENT_TYPE'];
        }
        if (isset($_SERVER['CONTENT_TYPE'])) {
            $contentType = $_SERVER['CONTENT_TYPE'];
        }

        // Get parameters
        $chunk = wf_gpc('chunk', 'r', 'intval');
        $chunks = wf_gpc('chunks', 'r', 'intval');

        // �����ļ���
        $file = $this->get_gpath($path . $name);
        if (!is_writeable($this->get_gpath($path))) {
            $this->error = '�ļ�ϵͳ���󣬵�ǰĿ¼û��д��Ȩ��';

            return false;
        } elseif (!$cover && file_exists($file)) {
            $this->error = '�ļ�ϵͳ����Ŀ���ļ��Ѵ���';

            return false;
        } elseif ($cover && file_exists($file) && !unlink($file)) {
            $this->error = '�ļ�ϵͳ�����޷�ɾ��ԭʼ�ļ�';

            return false;
        }

        // �ϴ�д�ļ�����,��һ�������µĴ����ֱ������
        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (false !== mb_strpos($contentType, 'multipart')) {
            if (!isset($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
                $this->error = 'Failed to move uploaded file.';

                return false;
            }

            // �ֿ�һֱ��move����С���ֿ�ʱ����������
            if (0 == $chunk) {
                if (!move_uploaded_file($_FILES['file']['tmp_name'], "{$file}.part")) {
                    $tihs->error = 'Failed to open output stream.';

                    return false;
                }
            } else {
                // �ϲ�ʣ��ֿ�����
                $out = fopen("{$file}.part", 0 == $chunk ? 'wb' : 'ab');
                if (!$out) {
                    $tihs->error = 'Failed to open output stream.';

                    return false;
                }

                $in = fopen($_FILES['file']['tmp_name'], 'rb');
                if (!$in) {
                    $tihs->error = 'Failed to open input stream.';

                    return false;
                }
                while ($buff = fread($in, 4096)) {
                    fwrite($out, $buff);
                }

                fclose($in);
                fclose($out);
            }

            file_exists($_FILES['file']['tmp_name']) && unlink($_FILES['file']['tmp_name']);
        } else {
            $out = fopen("{$file}.part", 0 == $chunk ? 'wb' : 'ab');
            if (!$out) {
                $tihs->error = 'Failed to open output stream.';

                return false;
            }

            // Read binary input stream and append it to temp file
            $in = fopen('php://input', 'rb');
            if (!$in) {
                $tihs->error = 'Failed to open input stream.';

                return false;
            }

            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }
            fclose($in);
            fclose($out);
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            return rename("{$file}.part", $file);
        }

        return true;
    }

    /**
     * �����ļ���֧��XSend.
     *
     * @param string $type �ļ�����
     * @param string $path �ļ�·��
     * @param string $name ��ʾ����
     */
    public function download($path, $name, $type = 'file')
    {
        $path = $this->get_gpath($path);
        if ('file' == $type && is_readable($path)) {
            $size = filesize($path);
        } elseif ('dir' == $type && is_readable($path)) {
            require WF_CORE_ROOT . 'PclZip.class.php';
            $name .= '.zip';
            $temp = './data/tmp/' . md5($path) . '.tmp';

            $Zip = new PclZip($temp);
            if (!$Zip->create($path, PCLZIP_OPT_REMOVE_PATH, $path)) {
                $this->error = '�ļ�ϵͳ����Ŀ¼�鵵����';

                return false;
            }
            $path = $temp;
            $size = filesize($temp);
        } else {
            $this->error = '�ļ�ϵͳ���󣬿���û�з���Ȩ��';

            return false;
        }

        // ����ļ�ͷ�����������ļ���
        $encoded_nname = rawurlencode($name);
        $ua = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/', $ua)) {
            header("Content-Disposition: attachment; filename={$encoded_nname}");
        } elseif (preg_match('/Firefox/', $ua)) {
            header("Content-Disposition: attachment; filename*=utf8'' {$name}");
        } else {
            header("Content-Disposition: attachment; filename={$name}");
        }
        header('Content-type: application/octet-stream');
        header('Content-Encoding: none');
        header('Cache-Control: private');
        header('Accept-Ranges: bytes');
        header('Pragma: no-cache');
        header('Expires: 0');
        header("Content-length: {$size}");
        header("Accept-Length: {$size}");

        // ��ʼ�����ļ�
        if (!is_readable($path)) {
            exit('û�ж�дȨ�ޣ�' . $path);
        } elseif (wf_config('X_SENDFILE_ON')) {
            // ʹ��X-Sendfile�����ļ�
            header("X-Sendfile: {$path}");
        } else {
            readfile($path);
        }

        if ('dir' == $type) {
            unlink($path);
        }
        exit();
    }

    /**
     * �ļ�����.
     *
     * @param string $type
     * @param array  $objs
     *
     * @return array
     */
    public function pathinfo($path, &$info = [])
    {
        $path = $this->get_gpath($path);
        if (!is_readable($path)) {
            $this->error = '�ļ�ϵͳ����Ŀ¼�����ڻ���û�з���Ȩ��';

            return false;
        }

        $info = stat($path);
        $info['dnums'] = $info['fnums'] = $info['size'] = 0;

        $list = $this->get_golblist($path);
        foreach ($list as $val) {
            if ('/' == mb_substr($val, -1, 1)) {
                ++$info['dnums'];
            } else {
                ++$info['fnums'];
                $info['size'] += filesize($val);
            }
        }

        $info['name'] = get_basename($path);
        $info['path'] = $this->get_upath($path);
        $info['fsize'] = get_deal_size($info['size']);
        $info['chmod'] = get_deal_chmod($path, 0);
        $info['fchmod'] = get_deal_chmod($path, 1);

        $info['fatime'] = date('Y��m��d�� H:i:s', $info['atime']);
        $info['fctime'] = date('Y��m��d�� H:i:s', $info['ctime']);
        $info['fmtime'] = date('Y��m��d�� H:i:s', $info['mtime']);
        $info['fmtime'] = date('Y��m��d�� H:i:s', $info['mtime']);

        return true;
    }

    public function thumb($path, $windth, $height)
    {
        $expire = 3600;
        $requestTime = $_SERVER['REQUEST_TIME'];
        $lastModified = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) : 0;

        if ($lastModified && $requestTime <= ($lastModified + $expire)) {
            header('HTTP/1.1 304 Not Modified', true);
            $responseTime = $lastModified;
            $exit = true;
        } else {
            $responseTime = $requestTime;
            $exit = false;
        }

        header('Cache-Control: max-age=' . $expire);
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $responseTime) . ' GMT');
        header('Expires: ' . gmdate('D, d M Y H:i:s', $responseTime + $expire) . ' GMT');
        if ($exit) {
            exit();
        }

        include WF_CORE_ROOT . 'Thumb.class.php';
        $path = $this->get_gpath($path);
        if (!is_readable($path)) {
            $path = WF_DATA_PATH . 'temp/nothumb.jpg';
        }

        $Thumb = new WF_Thumb();
        $Thumb->create($path, $windth, $height);
        $Thumb->show();
    }

    /**
     * ��ȡ������Ϣ.
     *
     * @return string
     */
    public function error()
    {
        return $this->error;
    }

    private function get_upath($path, $type = 'u')
    {
        $path = WF_SYS_WIN ? wf_g2u($path) : $path;
        if ('r' == $type) {
            $path = mb_substr($path, mb_strlen(WF_REAL_ROOT_PATH) - 1);
        }
        if ('u' == $type) {
            $path = mb_substr($path, mb_strlen(WF_REAL_USER_PATH) - 1);
        }

        return str_replace('//', '/', $path);
    }

    /**
     *  ����Ŀ¼�����굥.
     *
     * @param string $path ��ʼ·��
     * @param int    $deep ������� -1
     *
     * @return unknown
     */
    private function get_golblist($path, $deep = -1)
    {
        if (0 == $deep || !is_readable($path)) {
            return [];
        }
        $arrs = $info = [];
        $arrs = glob($path . '{,.}*', GLOB_MARK | GLOB_BRACE) or [];
        foreach ($arrs as $v) {
            $v = str_replace('\\', '/', $v);
            if (in_array(basename($v), ['.', '..'])) {
                continue;
            }

            $info[] = $v;
            if ('/' == mb_substr($v, -1, 1)) {
                $info = array_merge($info, $this->get_golblist($v, --$deep));
            }
        }

        return $info;
    }
}
