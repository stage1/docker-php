<?php

namespace Docker\Tests\Manager;

use Docker\API\Model\ContainerConfig;
use Docker\API\Model\ContainerCreateResult;
use Docker\Manager\ContainerManager;
use Docker\Tests\TestCase;

class ContainerManagerTest extends TestCase
{
    /**
     * Return the container manager
     *
     * @return ContainerManager
     */
    private function getManager()
    {
        return $this->getDocker()->getContainerManager();
    }

    public function testFindAll()
    {
        $manager    = $this->getManager();
        $containers = $manager->findAll();

        $this->assertInternalType('array', $containers);
    }

    public function testCreate()
    {
        $containerConfig = new ContainerConfig();
        $containerConfig->setImage('ubuntu:precise');
        $containerConfig->setCmd(['echo', '1']);

        $manager = $this->getManager();
        $containerCreateResult = $manager->create($containerConfig);

        $this->getManager()->remove($containerCreateResult->getId());

        $this->assertInstanceOf(ContainerCreateResult::class ,$containerCreateResult);
        $this->assertNotEmpty($containerCreateResult->getId());
    }

    public function testInspect()
    {
        $containerConfig = new ContainerConfig();
        $containerConfig->setImage('ubuntu:precise');
        $containerConfig->setCmd(['echo', '1']);

        $containerCreateResult = $this->getManager()->create($containerConfig);
        $container = $this->getManager()->find($containerCreateResult->getId());

        $this->getManager()->remove($containerCreateResult->getId());

        $this->assertInstanceOf('\Docker\API\Model\Container', $container);
        $this->assertEquals($container->getId(), $containerCreateResult->getId());
        $this->assertEquals('ubuntu:precise', $container->getConfig()->getImage());
        $this->assertEquals(['echo', '1'], $container->getConfig()->getCmd());
    }

    public function testStart()
    {
        $containerConfig = new ContainerConfig();
        $containerConfig->setImage('ubuntu:precise');
        $containerConfig->setCmd(['/bin/true']);

        $manager = $this->getManager();
        $containerCreateResult = $manager->create($containerConfig);
        $manager->start($containerCreateResult->getId());
        $container = $manager->find($containerCreateResult->getId());

        $this->getManager()->remove($containerCreateResult->getId());

        $this->assertEquals(0, $container->getState()->getExitCode());
    }

    public function testListProcesses()
    {
        $containerConfig = new ContainerConfig();
        $containerConfig->setImage('ubuntu:precise');
        $containerConfig->setCmd(['sleep', '10']);

        $manager = $this->getManager();
        $containerCreateResult = $manager->create($containerConfig);
        $manager->start($containerCreateResult->getId());

        $processes = $manager->listProcesses($containerCreateResult->getId());
        $this->getManager()->remove($containerCreateResult->getId());

        $this->assertInstanceOf('\Docker\API\Model\ContainerTop', $processes);
        $this->assertCount(1, $processes->getProcesses());
    }

    /**
    public function testInteract()
    {
        $container = new Container([
            'Image' => 'ubuntu:precise',
            'Cmd'   => ['/bin/bash'],
            'AttachStdin'  => false,
            'AttachStdout' => true,
            'AttachStderr' => true,
            'OpenStdin'    => true,
            'Tty'          => true,
        ]);

        $manager = $this->getManager();
        $manager->create($container);
        $stream = $manager->interact($container);
        $manager->start($container);

        $this->assertNotEmpty($container->getId());
        $this->assertInstanceOf('\Docker\Http\Stream\InteractiveStream', $stream);

        stream_set_blocking($stream->getSocket(), 0);

        $read   = [$stream->getSocket()];
        $write  = null;
        $expect = null;

        $stream->write("echo test\n");
        $data = "";
        do {
            $frame = $stream->receive(true);
            $data .= $frame['data'];
        } while (stream_select($read, $write, $expect, 1) > 0);

        $manager->stop($container, 1);

        $this->assertRegExp('#root@'.substr($container->getId(), 0, 12).':/\# echo test#', $data, $data);
    }

    public function testCreateThrowsRightFormedException()
    {
        $container = new Container(['Image' => 'non-existent']);

        $manager = $this->getManager();

        try {
            $manager->create($container);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $this->assertTrue($e->hasResponse());
            $this->assertEquals("404", $e->getResponse()->getStatusCode());
            $this->assertContains('No such image', $e->getMessage());
        }
    }

    public function testStart()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/true']]);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container);

        $runtimeInformations = $container->getRuntimeInformations();

        $this->assertEquals(0, $runtimeInformations['State']['ExitCode']);
    }

    public function testRunDefault()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/true']]);
        $manager = $this
            ->getMockBuilder('\Docker\Manager\ContainerManager')
            ->setMethods(['create', 'start', 'wait'])
            ->disableOriginalConstructor()
            ->getMock();

        $container->setExitCode(0);

        $manager->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $manager->expects($this->once())
            ->method('start')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $manager->expects($this->once())
            ->method('wait')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $this->assertTrue($manager->run($container));
    }

    public function testRunAttach()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/true']]);
        $manager = $this
            ->getMockBuilder('\Docker\Manager\ContainerManager')
            ->setMethods(['create', 'start', 'wait', 'attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $response = $this->getMockBuilder('\GuzzleHttp\Message\Response')->disableOriginalConstructor()->getMock();
        $stream   = $this->getMockBuilder('\GuzzleHttp\Stream\Stream')->disableOriginalConstructor()->getMock();

        $container->setExitCode(0);
        $callback = function () {};

        $manager->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $manager->expects($this->once())
            ->method('attach')
            ->with($this->isInstanceOf('\Docker\Container'), $this->equalTo($callback), $this->equalTo(true), $this->equalTo(true), $this->equalTo(true), $this->equalTo(true), $this->equalTo(true), $this->equalTo(null))
            ->will($this->returnValue($response));

        $manager->expects($this->once())
            ->method('start')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $response->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($stream));

        $manager->expects($this->once())
            ->method('wait')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $this->assertTrue($manager->run($container, $callback));
    }

    public function testRunDaemon()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/true']]);
        $manager = $this
            ->getMockBuilder('\Docker\Manager\ContainerManager')
            ->setMethods(['create', 'start', 'wait'])
            ->disableOriginalConstructor()
            ->getMock();

        $container->setExitCode(0);

        $manager->expects($this->once())
            ->method('create')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $manager->expects($this->once())
            ->method('start')
            ->with($this->isInstanceOf('\Docker\Container'))
            ->will($this->returnSelf());

        $manager->expects($this->never())
            ->method('wait');

        $this->assertNull($manager->run($container, null, [], true));
    }

    public function testAttach()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/bash', '-c', 'echo -n "output"']]);
        $manager = $this->getManager();

        $type   = 0;
        $output = "";

        $manager->create($container);
        $response = $manager->attach($container, function ($log, $stdtype) use (&$type, &$output) {
            $type = $stdtype;
            $output = $log;
        });
        $manager->start($container);

        $response->getBody()->getContents();

        $this->assertEquals(1, $type);
        $this->assertEquals('output', $output);
    }

    public function testAttachStderr()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/bash', '-c', 'echo -n "error" 1>&2']]);
        $manager = $this->getManager();

        $type   = 0;
        $output = "";

        $manager->create($container);
        $response = $manager->attach($container, function ($log, $stdtype) use (&$type, &$output) {
            $type = $stdtype;
            $output = $log;
        });
        $manager->start($container);

        $response->getBody()->getContents();

        $this->assertEquals(2, $type);
        $this->assertEquals('error', $output);
    }

    public function testWait()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/sleep', '1']]);

        $manager = $this->getManager();
        $manager->run($container);
        $manager->wait($container);

        $runtimeInformations = $container->getRuntimeInformations();

        $this->assertEquals(0, $runtimeInformations['State']['ExitCode']);
    }

    public function testWaitWithTimeout()
    {
        if (getenv('DOCKER_TLS_VERIFY')) {
            $this->markTestSkipped('This test failed when using ssl due to this bug : https://bugs.php.net/bug.php?id=41631');
        }

        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/sleep', '2']]);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container);
        $manager->wait($container, 1);
    }

    public function testTimeoutExceptionHasRequest()
    {
        if (getenv('DOCKER_TLS_VERIFY')) {
            $this->markTestSkipped('This test failed when using ssl due to this bug : https://bugs.php.net/bug.php?id=41631');
        }

        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/sleep', '2']]);

        $manager = $this->getManager();
        $manager->run($container);

        try {
            $manager->wait($container, 1);
        } catch (RequestException $e) {
            $this->assertInstanceOf('Docker\\Http\\Request', $e->getRequest());
        }
    }

    public function testExposeFixedPort()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/sleep', '1']]);

        $port = new Port('8888:80/tcp');

        $container->setExposedPorts($port);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container, ['PortBindings' => $port->toSpec()]);

        $this->assertEquals(8888, $container->getMappedPort(80)->getHostPort());
    }

    public function testExposeRandomPort()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/sleep', '1']]);

        $port = new Port('80/tcp');
        $container->setExposedPorts($port);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container, ['PortBindings' => $port->toSpec()]);

        $this->assertInternalType('integer', $container->getMappedPort(80)->getHostPort());
    }

    public function testInspect()
    {
        $manager = $this->getManager();

        $this->assertEquals(null, $manager->find('foo'));

        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/true']]);
        $manager->create($container);

        $this->assertInstanceOf('Docker\\Container', $manager->find($container->getId()));
    }

    public function testRemove()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['date']]);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container);
        $manager->wait($container);
        $manager->remove($container);

        $this->setExpectedException('\\Docker\\Exception\\ContainerNotFoundException', 'Container not found');
        $manager->inspect($container);
    }
    
    public function testForceRemove()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['tail', '-f', '/var/log/lastlog']]);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container);

        try {
            $manager->remove($container);
            $this->assertTrue(false);
        } catch (APIException $e) {
            $this->assertTrue(true);
        }

        $manager->remove($container, false, true);

        try {
            $manager->inspect($container);
            $this->assertTrue(false);
        } catch (ContainerNotFoundException $e) {
            $this->assertTrue(true);
        }
    }

    public function testRemoveContainers()
    {
        $containers = ['3360ea744df2', 'a412d121d015'];
        $manager = $this
            ->getMockBuilder('\Docker\Manager\ContainerManager')
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $manager->expects($this->exactly(2))
            ->method('remove')
            ->with($this->isInstanceOf('\Docker\Container'), false)
            ->will($this->returnSelf());

        $manager->removeContainers($containers);
    }
    
    public function testForceRemoveContainers()
    {
        $containers = ['3360ea744df2', 'a412d121d015'];
        $manager = $this
            ->getMockBuilder('\Docker\Manager\ContainerManager')
            ->setMethods(['remove'])
            ->disableOriginalConstructor()
            ->getMock();

        $manager->expects($this->exactly(2))
            ->method('remove')
            ->with($this->isInstanceOf('\Docker\Container'), false, true)
            ->will($this->returnSelf());

        $manager->removeContainers($containers, false, true);
    }

    public function testTop()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['sleep', '5']]);
        $manager = $this->getManager();
        $manager->run($container, null, [], true);

        sleep(1);

        $processes = $manager->top($container);

        $this->assertCount(1, $processes);
        $this->assertArrayHasKey('COMMAND', $processes[0]);
        $this->assertEquals('sleep 5', $processes[0]['COMMAND']);

        $manager->kill($container);
        $manager->remove($container);
    }

    public function testChanges()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['touch', '/docker-php-test']]);
        $manager = $this->getManager();
        $manager->run($container);
        $manager->wait($container);

        $changes = $manager->changes($container);

        $manager->remove($container);

        $this->assertCount(1, $changes);
        $this->assertEquals('/docker-php-test', $changes[0]['Path']);
        $this->assertEquals(1, $changes[0]['Kind']);
    }

    public function testExport()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['touch', '/docker-php-test']]);
        $manager = $this->getManager();
        $manager->run($container);
        $manager->wait($container);

        $exportStream = $manager->export($container);

        $this->assertInstanceOf('\GuzzleHttp\Stream\Stream', $exportStream);

        $tarFileName  = tempnam(sys_get_temp_dir(), 'docker-php-export-test-');
        $tarFile      = fopen($tarFileName, 'w+');

        stream_copy_to_stream($exportStream->detach(), $tarFile);
        fclose($tarFile);

        exec('/usr/bin/env tar -tf '.$tarFileName, $output);

        $this->assertContains('docker-php-test', $output);
        $this->assertContains('.dockerinit', $output);

        unlink($tarFileName);
        $manager->remove($container);
    }

    public function testCopyToDisk()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['touch', '/etc/default/docker-php-test']]);
        $manager = $this->getManager();
        $manager->run($container);
        $manager->wait($container);

        $tarFileName  = tempnam(sys_get_temp_dir(), 'testcopyToDisk.tar');
        $manager->copyToDisk($container, '/etc/default', $tarFileName);

        exec('/usr/bin/env tar -tf '.$tarFileName, $output);
        $this->assertContains('default/docker-php-test', $output);

        unlink($tarFileName);
        $manager->remove($container);
    }

    public function testLogs()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['echo', 'test']]);
        $manager = $this->getManager();
        $manager->run($container);
        $manager->stop($container);
        $logs = $manager->logs($container, false, true);
        $manager->remove($container);

        $this->assertGreaterThanOrEqual(1, count($logs));

        $logs = array_map(function ($value) {
            return $value['output'];
        }, $logs);

        $this->assertContains("test", implode("", $logs));
    }

    public function testRestart()
    {
        $manager = $this->getManager();

        $container = new Container(['Image' => 'busybox', 'Cmd' => ['sleep', '10']]);

        $manager->create($container);
        $manager->start($container);
        $this->assertEquals('0001-01-01T00:00:00Z', $container->getRuntimeInformations()['State']['FinishedAt']);

        $manager->restart($container);
        $this->assertNotEquals('0001-01-01T00:00:00Z', $container->getRuntimeInformations()['State']['FinishedAt']);

        $manager->stop($container);
        $manager->remove($container);
    }

    public function testKill()
    {
        $manager = $this->getManager();
        $dockerFileBuilder = new ContextBuilder();
        $dockerFileBuilder->from('ubuntu:precise');
        $dockerFileBuilder->add('/kill.sh', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'script' . DIRECTORY_SEPARATOR . 'kill.sh'));
        $dockerFileBuilder->run('chmod +x /kill.sh');

        $this->getDocker()->build($dockerFileBuilder->getContext(), 'docker-php-kill-test', null, true, false, true);

        $container = new Container(['Image' => 'docker-php-kill-test:latest', 'Cmd' => ['/kill.sh']]);
        $manager->create($container);
        $manager->start($container);
        $manager->kill($container, "SIGHUP");
        $manager->wait($container);

        $logs = $manager->logs($container, false, true);
        $logs = array_map(function ($value) {
            return $value['output'];
        }, $logs);

        $manager->remove($container);
        $this->getDocker()->getImageManager()->remove($container->getImage());

        $this->assertContains('HUP', implode("", $logs));
    }

    public function testExec()
    {
        $manager = $this->getManager();
        $dockerFileBuilder = new ContextBuilder();
        $dockerFileBuilder->from('ubuntu:precise');
        $dockerFileBuilder->add('/daemon.sh', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'script' . DIRECTORY_SEPARATOR . 'daemon.sh'));
        $dockerFileBuilder->run('chmod +x /daemon.sh');

        $this->getDocker()->build($dockerFileBuilder->getContext(), 'docker-php-restart-test', null, true, false, true);

        $container = new Container(['Image' => 'docker-php-restart-test', 'Cmd' => ['/daemon.sh']]);
        $manager->create($container);
        $manager->start($container);

        $type   = 0;
        $output = "";
        $execId = $manager->exec($container, ['/bin/bash', '-c', 'echo -n "output"']);

        $this->assertNotNull($execId);

        $response = $manager->execstart($execId, function ($log, $stdtype) use (&$type, &$output) {
            $type = $stdtype;
            $output = $log;
        });

        $response->getBody()->getContents();

        $manager->kill($container);
        $manager->remove($container);

        $this->assertEquals(1, $type);
        $this->assertEquals('output', $output);
    }

    public function testExecInspect()
    {
        $manager = $this->getManager();
        $dockerFileBuilder = new ContextBuilder();
        $dockerFileBuilder->from('ubuntu:precise');
        $dockerFileBuilder->add('/daemon.sh', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'script' . DIRECTORY_SEPARATOR . 'daemon.sh'));
        $dockerFileBuilder->run('chmod +x /daemon.sh');

        $this->getDocker()->build($dockerFileBuilder->getContext(), 'docker-php-restart-test', null, true, false, true);

        $container = new Container(['Image' => 'docker-php-restart-test', 'Cmd' => ['/daemon.sh']]);
        $manager->create($container);
        $manager->start($container);

        $execId = $manager->exec($container, ['/bin/bash', '-c', 'echo -n "output"']);
        $inspection = $manager->execinspect($execId);

        $this->assertEquals(0, $inspection->ExitCode);
        $this->assertEquals(false, $inspection->Running);
    }

    public function testRename()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/true']]);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container);
        $manager->rename($container, 'FoobarRenamed');

        $runtimeInformations = $container->getRuntimeInformations();
		
        $this->assertInstanceOf('Docker\\Container', $manager->find('FoobarRenamed'));
        $manager->stop($container);   // cleanup
        $manager->remove($container);
    }

    public function testPause()
    {
        $container = new Container(['Image' => 'ubuntu:precise', 'Cmd' => ['/bin/sleep', '1']]);

        $manager = $this->getManager();
        $manager->create($container);
        $manager->start($container);

        $runtimeInformations = $container->getRuntimeInformations();
        $this->assertEquals(false, $runtimeInformations['State']['Paused']);
        $this->assertEquals(true, $runtimeInformations['State']['Running']);

        $manager->pause($container);

        $runtimeInformations = $container->getRuntimeInformations();
        $this->assertEquals(true, $runtimeInformations['State']['Paused']);
        $this->assertEquals(true, $runtimeInformations['State']['Running']);

        $manager->unpause($container);

        $runtimeInformations = $container->getRuntimeInformations();
        $this->assertEquals(false, $runtimeInformations['State']['Paused']);
        $this->assertEquals(true, $runtimeInformations['State']['Running']);

        // cleanup
        $manager->stop($container);
        $manager->remove($container);
    }*/

}
