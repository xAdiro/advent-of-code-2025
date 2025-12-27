def part2():
    with open("input.txt", "r") as f:
        file = f.read().splitlines()

    graph_matrix: dict[str, set[str]] = dict()

    for line in file:
        name = line[:3]
        neighbours = line[5:].split(" ")
        graph_matrix[name] = neighbours

    graph_matrix["out"] = []

    to_remove = set()
    for name, _ in graph_matrix.items():
        if name != "out" and name != "svr" and not is_connected("svr", name, graph_matrix) or \
            (
                # dac -> .. s .. -> fft
                not (is_connected(name, "fft", graph_matrix)
                     and is_connected("dac", name, graph_matrix))
                # fft -> .. s .. -> dac
                and not (is_connected("fft", name, graph_matrix) and is_connected(name, "dac", graph_matrix))
                #  s .. -> fft, dac
                and not (is_connected(name, "fft", graph_matrix) and is_connected(name, "dac", graph_matrix))
                #   fft, dac .. -> s
                and not (is_connected("fft", name, graph_matrix) and is_connected("dac", name, graph_matrix))
        ):

            to_remove.add(name)

    for node in to_remove:
        del graph_matrix[node]

    for start, neighbours in graph_matrix.items():
        graph_matrix[start] = [
            node for node in neighbours if node not in to_remove]

    print(count_paths2("svr", "out", graph_matrix))


def is_connected(start, end, graph_matrix, visited=None):
    if visited is None:
        visited = set()

    if start == end:
        return True

    if start in visited:
        return False
    else:
        visited.add(start)

    for neighbour in graph_matrix[start]:
        if is_connected(neighbour, end, graph_matrix, visited):
            return True


counted = dict()


def count_paths2(start, end, graph_matrix, visited_end=False, visited_fft=False, visited_dac=False):
    cache = counted.get((start, end, visited_end, visited_fft, visited_dac))
    if cache is not None:
        return cache

    if start == "fft":
        visited_fft = True
    elif start == "dac":
        visited_dac = True

    if start == end:
        if visited_fft and visited_dac:
            counted[(start, end, visited_end, visited_fft, visited_dac)] = 1
            return 1
        elif visited_end:
            counted[(start, end, visited_end, visited_fft, visited_dac)] = 0
            return 0
        else:
            visited_end = True

    if len(graph_matrix[start]) == 0:
        counted[(start, end, visited_end, visited_fft, visited_dac)] = 0
        return 0

    result = sum((count_paths2(node, end, graph_matrix, visited_end,
                 visited_fft, visited_dac) for node in graph_matrix[start]))

    counted[(start, end, visited_end, visited_fft, visited_dac)] = result
    return result


if __name__ == "__main__":
    part2()
